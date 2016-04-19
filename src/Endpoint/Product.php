<?php

namespace CodeCloud\ShopifyApiClient\Endpoint;

class Product extends Endpoint
{
    public function search(array $params)
    {
        $response = $this->api->get($this->getMethod('search')->getUrl(), $params);
        return $response->get('products');
    }

    public function count(array $params)
    {
        $response = $this->api->get($this->getMethod('count')->getUrl(), $params);
        return $response->get('count');
    }

    public function get($productId, array $params)
    {
        $url = $this->getMethod('get')->constructUrlWithParams(compact($productId));
        $response = $this->api->get($url, $params);
        return $response->get('product');
    }

    public function create($title, array $params)
    {
        $params = array_merge($params, compact($title));
        $response = $this->api->post($this->getMethod('create')->getUrl(), $params);
        return $response->get('product');
    }

    public function update($productId, $title, array $params)
    {
        $params = array_merge($params, compact($title));
        $url = $this->getMethod('update')->constructUrlWithParams(compact($productId));
        $response = $this->api->put($url, $params);
        return $response->get('product');
    }

    public function delete($productId)
    {
        $url = $this->getMethod('delete')->constructUrlWithParams(compact($productId));
        $response = $this->api->delete($url);
        return $response;
    }
}
