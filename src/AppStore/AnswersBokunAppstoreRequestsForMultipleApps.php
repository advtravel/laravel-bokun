<?php

namespace Adventures\LaravelBokun\AppStore;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait AnswersBokunAppstoreRequestsForMultipleApps
{
    use AnswersBokunAppstoreRequests;

    abstract protected function getAppFromRequest(Request $request): BokunApp;

    protected function getAppConfig(): BokunAppConfig
    {
        try {
            return $this->getAppFromRequest(request())->getBokunAppConfig();
        } catch (InvalidBokunApp $e) {
            throw new NotFoundHttpException(previous: $e);
        }
    }

    abstract protected function loginOperatorForApp(BokunApp $app, Request $request, BokunAppStoreOperator $operator): RedirectResponse;

    protected function loginOperator(Request $request, BokunAppStoreOperator $operator): RedirectResponse
    {
        return $this->loginOperatorForApp($this->getAppFromRequest($request), $request, $operator);
    }

    abstract protected function createOperatorForApp(BokunApp $app, Request $request, OperatorDetails $operator): BokunAppStoreOperator;

    protected function createOperator(Request $request, OperatorDetails $details): BokunAppStoreOperator
    {
        return $this->createOperatorForApp($this->getAppFromRequest($request), $request, $details);
    }

    abstract protected function getOperatorByDomainForApp(BokunApp $app, string $domain): BokunAppStoreOperator;

    protected function getOperatorByDomain(string $domain): BokunAppStoreOperator
    {
        return $this->getOperatorByDomainForApp($this->getAppFromRequest(request()), $domain);
    }

    abstract protected function getOperatorByVendorIDForApp(BokunApp $app, int $vendor_id): BokunAppStoreOperator;

    protected function getOperatorByVendorID(int $vendor_id): BokunAppStoreOperator
    {
        return $this->getOperatorByVendorIDForApp($this->getAppFromRequest(request()), $vendor_id);
    }
}
