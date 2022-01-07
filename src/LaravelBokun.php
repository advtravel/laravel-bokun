<?php

namespace Adventures\LaravelBokun;

class BokunController
{
    public function __construct(private ICanStoreCompanies $company_storage)
    {
    }
}
