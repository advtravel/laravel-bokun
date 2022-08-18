<?php

namespace Adventures\LaravelBokun\AppStore;

use Illuminate\Support\Arr;
use RuntimeException;

class OperatorDetails
{
    public string $title;
    public string $email;

    public string $domain;

    public ?int $vendor_id = null;

    public ?string $access_token = null;
    public ?string $legacy_access_key = null;
    public ?string $legacy_secret_key = null;
    public ?string $user_name = null;
    public ?string $user_email = null;

    public function fillFromAccessTokenReponse(AccessTokenResponse $accessTokenResponse): void
    {
        $this->user_name = $accessTokenResponse->app_installed_by_name;
        $this->user_email = $accessTokenResponse->app_installed_by_email;
        $this->access_token = $accessTokenResponse->access_token;
        $this->vendor_id = $accessTokenResponse->vendor_id;
        $this->legacy_access_key = $accessTokenResponse->legacy_access_key;
        $this->legacy_secret_key = $accessTokenResponse->legacy_secret_key;
    }

    protected function fieldMapping(): array
    {
        return [
            'title' => 'name',
            'email' => 'contact.emailAddress',
            'domain' => 'domain',
        ];
    }

    public function fillFromVendorData(array $vendor): void
    {
        foreach ($this->fieldMapping() as $field => $array_key) {
            if (! Arr::has($vendor, $array_key)) {
                throw new RuntimeException();
            }

            $this->{$field} = Arr::get($vendor, $array_key);
        }
    }
}
