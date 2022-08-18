<?php

namespace Adventures\LaravelBokun\AppStore;

interface BokunAppStoreOperator
{
    public function isFullyOAuthConnected(): bool;
    public function updateWithOperatorDetails(OperatorDetails $info): void;
    public function getAccessToken(): string;
}
