<?php

namespace CodeCloud\ShopifyApiClient\Endpoint;

class Metafield extends Endpoint
{
    public function fields(array $params)
    {
        $response = $this->api->get($this->getMethod('fields')->getUrl(), $params);
        return $response->get('metafields');
    }

    public function storeFields(array $params)
    {
        $response = $this->api->get($this->getMethod('storeFields')->getUrl(), $params);
        return $response->get('metafields');
    }

    public function count()
    {
        $response = $this->api->get($this->getMethod('count')->getUrl());
        return $response->get('count');
    }

    public function productFields($productId)
    {
        $url = $this->getMethod('productFields')->constructUrlWithParams(compact('productId'));
        $response = $this->api->get($url);
        return $response->get('metafields');
    }

    public function productCount($productId)
    {
        $url = $this->getMethod('productCount')->constructUrlWithParams(compact('productId'));
        $response = $this->api->get($url);
        return $response->get('count');
    }

    public function get($metafieldId, array $params)
    {
        $url = $this->getMethod('get')->constructUrlWithParams(compact('metafieldId'));
        $response = $this->api->get($url, $params);
        return $response->get('metafield');
    }

    public function getProduct($productId, $metafieldId)
    {
        $url = $this->getMethod('getProduct')->constructUrlWithParams(compact('productId', 'metafieldId'));
        $response = $this->api->get($url);
        return $response->get('metafield');
    }

    public function create($key, array $params)
    {
        $params = array_merge($params, compact('key'));
        $params = ['metafield' => $params];
        $response = $this->api->post($this->getMethod('create')->getUrl(), $params);
        return $response->get('metafield');
    }

    public function update($key, array $params)
    {
        $params = array_merge($params, compact('key'));
        $params = ['metafield' => $params];
        $response = $this->api->put($this->getMethod('update')->getUrl(), $params);
        return $response->get('metafield');
    }

    public function updateProduct(array $params)
    {
        $params = ['metafield' => $params];
        $response = $this->api->put($this->getMethod('updateProduct')->getUrl(), $params);
        return $response->get('metafield');
    }

    public function delete($metafieldId)
    {
        $url = $this->getMethod('delete')->constructUrlWithParams(compact('metafieldId'));
        $response = $this->api->delete($url);
        return $response;
    }

    public function deleteProduct($productId, $metafieldId)
    {
        $url = $this->getMethod('deleteProduct')->constructUrlWithParams(compact('productId', 'metafieldId'));
        $response = $this->api->delete($url);
        return $response;
    }
}
