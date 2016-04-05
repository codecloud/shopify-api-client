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
     * @return Endpoint\Article
     */
    public function article()
    {
        return $this->createEndpointProxy('Article');
    }

    /**
     * @return Endpoint\ApplicationCharge
     */
    public function applicationCharge()
    {
        return $this->createEndpointProxy('ApplicationCharge');
    }

    /**
     * @return Endpoint\Asset
     */
    public function asset()
    {
        return $this->createEndpointProxy('Asset');
    }

    /**
     * @return Endpoint\Blog
     */
    public function blog()
    {
        return $this->createEndpointProxy('Blog');
    }

    /**
     * @return Endpoint\CarrierService
     */
    public function carrierService()
    {
        return $this->createEndpointProxy('CarrierService');
    }

    /**
     * @return Endpoint\CheckoutApi
     */
    public function checkoutApi()
    {
        return $this->createEndpointProxy('CheckoutAPI');
    }

    /**
     * @return Endpoint\Collect
     */
    public function collect()
    {
        return $this->createEndpointProxy('Collect');
    }

    /**
     * @return Endpoint\CustomCollection
     */
    public function customCollection()
    {
        return $this->createEndpointProxy('CustomCollection');
    }

    /**
     * @return Endpoint\Event
     */
    public function event()
    {
        return $this->createEndpointProxy('Event');
    }

    /**
     * @return Endpoint\Metafield
     */
    public function metafield()
    {
        return $this->createEndpointProxy('Metafield');
    }

    /**
     * @return Endpoint\Product
     */
    public function product()
    {
        return $this->createEndpointProxy('Product');
    }

    /**
     * @return Endpoint\ScriptTag
     */
    public function scriptTag()
    {
        return $this->createEndpointProxy('ScriptTag');
    }

    /**
     * @return Endpoint\Shop
     */
    public function shop()
    {
        return $this->createEndpointProxy('Shop');
    }

    /**
     * @return Endpoint\SmartCollection
     */
    public function smartCollection()
    {
        return $this->createEndpointProxy('SmartCollection');
    }

    /**
     * @return Endpoint\Theme
     */
    public function theme()
    {
        return $this->createEndpointProxy('Theme');
    }

    /**
     * @return Endpoint\Webhook
     */
    public function webhook()
    {
        return $this->createEndpointProxy('Webhook');
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

