<?php

namespace CodeCloud\ShopifyApiClient\Endpoint;

class Blog extends Endpoint
{
    public function search(array $params)
    {
        $response = $this->api->get($this->getMethod('search')->getUrl(), $params);
        return $response->get('blogs');
    }

    public function count()
    {
        $response = $this->api->get($this->getMethod('count')->getUrl());
        return $response->get('count');
    }

    public function get($blogId, array $params)
    {
        $url = $this->getMethod('get')->constructUrlWithParams(compact($blogId));
        $response = $this->api->get($url, $params);
        return $response->get('blog');
    }

    public function create($title, array $params)
    {
        $params = array_merge($params, compact($title));
        $response = $this->api->post($this->getMethod('create')->getUrl(), $params);
        return $response->get('blog');
    }

    public function update($blogId, array $params)
    {
        $url = $this->getMethod('update')->constructUrlWithParams(compact($blogId));
        $response = $this->api->put($url, $params);
        return $response->get('blog');
    }

    public function delete($blogId)
    {
        $url = $this->getMethod('delete')->constructUrlWithParams(compact($blogId));
        $response = $this->api->delete($url);
        return $response;
    }
}
