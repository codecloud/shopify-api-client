<?php

namespace CodeCloud\ShopifyApiClient\Endpoint;

class CheckoutAPI extends Endpoint
{
    public function create(array $params)
    {
        $params = ['checkout' => $params];
        $response = $this->api->post($this->getMethod('create')->getUrl(), $params);
        return $response->get('checkout');
    }

    public function get($checkoutToken)
    {
        $url = $this->getMethod('get')->constructUrlWithParams(compact($checkoutToken));
        $response = $this->api->get($url);
        return $response->get('checkout');
    }

    public function update(array $params)
    {
        $params = ['checkout' => $params];
        $response = $this->api->patch($this->getMethod('update')->getUrl(), $params);
        return $response->get('checkout');
    }

    public function shippingRates()
    {
        $response = $this->api->get($this->getMethod('shippingRates')->getUrl());
        return $response->get('shipping_rates');
    }

    public function selectShippingRate(array $params)
    {
        $response = $this->api->patch($this->getMethod('selectShippingRate')->getUrl(), $params);
        return $response;
    }

    public function payment(object $source)
    {
        $params = array_merge($params, compact($source));
        $params = ['checkout' => $params];
        $response = $this->api->post($this->getMethod('payment')->getUrl());
        return $response->get('checkout');
    }
}
