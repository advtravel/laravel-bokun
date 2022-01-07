<?php

namespace Adventures\LaravelBokun;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Throwable;

trait AnswersBokunAppstoreRequests
{
    use MakesBokunRequests;

    private static $nonce_session_key = 'bokun_appstore_nonce';

    public function initialRequest(Request $request)
    {
        $config = $this->getAppConfig($request);

        abort_unless($this->hmacIsvalid($request->query()), 403, 'HMAC is invalid');

        $nonce = mt_rand();
        session([self::$nonce_session_key => $nonce]);

        $redirect_url = $config->oauth_redirect_url;

        // ngrok creates a https tunnel to a localhost http
        // so when debugging we want to rewrite the http:// that's generated to https://
        if (config('app.debug')) {
            if (str_starts_with($redirect_url, 'http://') && str_contains($redirect_url, 'ngrok.io/')) {
                $redirect_url = 'https://' . substr($redirect_url, 7);
            }
        }

        $bokunUrl =
            $this->bokunBaseURL($request->query('domain'))
            . '/appstore/oauth/authorize?'
            . http_build_query([
                'client_id' => $this->getAppConfig()->app_id,
                'scope' => config('bokun.scope'),
                'redirect_uri' => $redirect_url,
                'state' => $nonce,
            ]);

        return redirect($bokunUrl);
    }

    protected function handleAccessCodeRequest(Request $request): AccessTokenResponse
    {
        abort_unless($this->hmacIsvalid($request->query()), 403, 'HMAC is invalid');

        abort_unless($this->nonceIsValid($request->query()), 403, 'Invalid state');

        return $this->requestAccessToken($request->query('domain'), $request->query('code'));
    }

    protected function handleUninstallRequest(BokunUninstallRequest $request): int
    {
        $bokunHeaders = $request->getBokunHeaders();
        abort_unless($this->hmacIsvalid($bokunHeaders, 'x-bokun-hmac'), 403, 'HMAC is invalid.');

        abort_unless(array_key_exists('x-bokun-topic', $bokunHeaders), 400, 'No x-bokun-topic set.');

        abort_unless($bokunHeaders['x-bokun-topic'] === 'apps/uninstall', 501, 'This endpoint only handles apps/uninstall calls');

        return (int) $this->parseB64ID($bokunHeaders['x-bokun-vendor-id'])['Vendor'];
    }

    /**
     * Like http_build_query but only accepts a flat input array as parameter
     * And nothing is encoded. This is how Bókun builds the query for HMAC validation
     */
    private function buildQuery(array $query): string
    {
        if (! count($query)) {
            return '';
        }
        $return = '';
        foreach ($query as $key => $value) {
            if ($return) {
                $return .= '&';
            }
            $return .= $key . '=' . $value;
        }

        return $return;
    }

    private function nonceIsValid(array $query): bool
    {
        if (! array_key_exists('state', $query)) {
            return false;
        }

        return $query['state'] === (string) session(self::$nonce_session_key);
    }

    private function hmacIsvalid(array $query, string $key = 'hmac'): bool
    {
        if (! array_key_exists($key, $query)) {
            return false;
        }

        $hmac = $query[$key];
        unset($query[$key]);
        ksort($query);

        $query_to_verify = $this->buildQuery($query);

        $hash = hash_hmac('sha256', $query_to_verify, $this->getAppConfig()->app_secret, false);

        return $hash === $hmac;
    }

    private function requestAccessToken(string $domain, string $code): AccessTokenResponse
    {
        $client = new Client();

        $bokunUrl =
            $this->bokunBaseURL($domain)
            . '/appstore/oauth/access_token';

        try {
            $response = $client->post($bokunUrl, [
                'json' => [
                    'client_id' => $this->getAppConfig()->app_id,
                    'client_secret' => $this->getAppConfig()->app_secret,
                    'code' => $code,
                ],
            ])->getBody();

            $response_data = json_decode($response, associative: true, flags: JSON_THROW_ON_ERROR);
        } catch (Throwable) {
            abort(500, "Invalid access token response");
        }

        return new AccessTokenResponse(
            $response_data['access_token'],
            $response['appInstalledByUserFirstName'] . ' ' . $response['appInstalledByUserLastName'],
            $response['appInstalledByUserEmail'],
            (int) $this->parseB64ID($response['vendor_id'])['Vendor'],
            $domain
        );
    }
}
