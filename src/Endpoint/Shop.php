<?php

namespace Codecloud\ShopifyApiClient\Endpoint;

class Shop extends Endpoint
{
    public function get(array $params)
    {
        $response = $this->api->get($this->getMethod('get')->getUrl(), $params);
        return $response->get('shop');
    }
}
