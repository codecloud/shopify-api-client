<?php

namespace CodeCloud\ShopifyApiClient\Endpoint;

class SmartCollection extends Endpoint
{
    public function search(array $params)
    {
        $response = $this->api->get($this->getMethod('search')->getUrl(), $params);
        return $response->get('smart_collections');
    }

    public function count(array $params)
    {
        $response = $this->api->get($this->getMethod('count')->getUrl(), $params);
        return $response->get('count');
    }

    public function get($smartCollectionId, array $params)
    {
        $url = $this->getMethod('get')->constructUrlWithParams(compact($smartCollectionId));
        $response = $this->api->get($url, $params);
        return $response->get('smart_collection');
    }

    public function create($title, array $params)
    {
        $params = array_merge($params, compact($title));
        $params = ['smart_collection' => $params];
        $response = $this->api->post($this->getMethod('create')->getUrl(), $params);
        return $response->get('smart_collection');
    }

    public function update($smartCollectionId, $title, array $params)
    {
        $params = array_merge($params, compact($title));
        $params = ['smart_collection' => $params];
        $url = $this->getMethod('update')->constructUrlWithParams(compact($smartCollectionId));
        $response = $this->api->put($url, $params);
        return $response->get('smart_collection');
    }

    public function order($smartCollectionId, array $params)
    {
        $url = $this->getMethod('order')->constructUrlWithParams(compact($smartCollectionId));
        $response = $this->api->put($url, $params);
        return $response;
    }

    public function delete($smartCollectionId)
    {
        $url = $this->getMethod('delete')->constructUrlWithParams(compact($smartCollectionId));
        $response = $this->api->delete($url);
        return $response;
    }
}
