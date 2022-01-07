<?php

namespace Adventures\LaravelBokun;

use Illuminate\Http\Request;

class BokunUninstallRequest extends Request
{
    public function getBokunHeaders(): array
    {
        $all_headers = getallheaders();

        // Walk over headers, convert all keys to strtolower, filter by those without x-bokun
        $headers = [];
        foreach ($all_headers as $key => $value) {
            $key = strtolower($key);
            if (! str_starts_with($key, 'x-bokun')) {
                continue;
            }
            $headers[$key] = $value;
        }

        return $headers;
    }
}
