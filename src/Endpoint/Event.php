<?php

namespace Codecloud\ShopifyApiClient\Endpoint;

class Event extends Endpoint
{
    public function product($productId, array $params)
    {
        $url = $this->getMethod('product')->constructUrlWithParams(compact($productId));
        $response = $this->api->get($url, $params);
        return $response->get('events');
    }

    public function order($orderId, array $params)
    {
        $url = $this->getMethod('order')->constructUrlWithParams(compact($orderId));
        $response = $this->api->get($url, $params);
        return $response->get('events');
    }

    public function search(array $params)
    {
        $response = $this->api->get($this->getMethod('search')->getUrl(), $params);
        return $response->get('events');
    }

    public function count(array $params)
    {
        $response = $this->api->get($this->getMethod('count')->getUrl(), $params);
        return $response->get('count');
    }
}
