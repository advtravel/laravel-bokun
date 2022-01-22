<?php

namespace Adventures\LaravelBokun;

class AccessTokenResponse
{
    public function __construct(
        public string $access_token,
        public string $app_installed_by_name,
        public string $app_installed_by_email,
        public int $vendor_id,
        public string $bokun_domain,
        public ?string $legacy_access_key = null,
        public ?string $legacy_secret_key = null,
    ) {
    }
}
