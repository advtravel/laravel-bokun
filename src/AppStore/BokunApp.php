<?php

namespace Adventures\LaravelBokun\AppStore;

interface BokunApp
{
    public function getBokunAppConfig(): BokunAppConfig;
}
