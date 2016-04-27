<?php

namespace CodeCloud\ShopifyApiClient\Endpoint;

class CustomCollection extends Endpoint
{
    public function search(array $params)
    {
        $response = $this->api->get($this->getMethod('search')->getUrl(), $params);
        return $response->get('custom_collections');
    }

    public function count(array $params)
    {
        $response = $this->api->get($this->getMethod('count')->getUrl(), $params);
        return $response->get('count');
    }

    public function get($customCollectionId, array $params)
    {
        $url = $this->getMethod('get')->constructUrlWithParams(compact('customCollectionId'));
        $response = $this->api->get($url, $params);
        return $response->get('custom_collection');
    }

    public function create($title, array $params)
    {
        $params = array_merge($params, compact('title'));
        $params = ['custom_collection' => $params];
        $response = $this->api->post($this->getMethod('create')->getUrl(), $params);
        return $response->get('custom_collection');
    }

    public function update($customCollectionId, $title, array $params)
    {
        $params = array_merge($params, compact('title'));
        $params = ['custom_collection' => $params];
        $url = $this->getMethod('update')->constructUrlWithParams(compact('customCollectionId'));
        $response = $this->api->put($url, $params);
        return $response->get('custom_collection');
    }

    public function delete($customCollectionId)
    {
        $url = $this->getMethod('delete')->constructUrlWithParams(compact('customCollectionId'));
        $response = $this->api->delete($url);
        return $response;
    }
}
