<?php

namespace CodeCloud\ShopifyApiClient\Endpoint;

class AbandonedCheckouts extends Endpoint
{
    public function count(enum $status, array $params)
    {
        $params = array_merge($params, compact('status'));
        $response = $this->api->get($this->getMethod('count')->getUrl(), $params);
        return $response->get('count');
    }

    public function search(array $params)
    {
        $response = $this->api->get($this->getMethod('search')->getUrl(), $params);
        return $response->get('checkouts');
    }
}
