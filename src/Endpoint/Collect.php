<?php

namespace CodeCloud\ShopifyApiClient\Endpoint;

class Collect extends Endpoint
{
    public function create($product_id, $collection_id, array $params)
    {
        $params = array_merge($params, compact($product_id, $collection_id));
        $response = $this->api->post($this->getMethod('create')->getUrl(), $params);
        return $response->get('collect');
    }

    public function delete()
    {
        $response = $this->api->delete($this->getMethod('delete')->getUrl());
        return $response;
    }

    public function search(array $params)
    {
        $response = $this->api->get($this->getMethod('search')->getUrl(), $params);
        return $response->get('collects');
    }

    public function count(array $params)
    {
        $response = $this->api->get($this->getMethod('count')->getUrl(), $params);
        return $response->get('count');
    }

    public function get($collectId, array $params)
    {
        $url = $this->getMethod('get')->constructUrlWithParams(compact($collectId));
        $response = $this->api->get($url, $params);
        return $response->get('collect');
    }
}
