<?php

namespace Adventures\LaravelBokun;

class BokunAppConfig
{
    public function __construct(
        public string $app_id,
        public string $app_secret,
        public string $scope,
        public string $base_url,
        public string $oauth_redirect_url,
    ) {}
}
