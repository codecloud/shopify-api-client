<?php
namespace Codecloud\ShopifyApiClient;

use Codecloud\ShopifyApiClient\EndpointFramework\EndpointProxy;

class Client
{
    /**
     * @return Endpoint\AbandonedCheckouts
     */
    public function abandonedCheckouts()
    {
        return $this->createEndpointProxy('AbandonedCheckouts');
    }

    /**
     * @param string $endpointName
     * @return EndpointProxy
     */
    private function createEndpointProxy($endpointName)
    {
        return EndpointProxy::create($endpointName, $this);
    }
}

