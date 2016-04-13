<?php

namespace Codecloud\ShopifyApiClient\Endpoint;

class Article extends Endpoint
{
    public function search($blogId, array $params)
    {
        $url = $this->getMethod('search')->constructUrlWithParams(compact($blogId));
        $response = $this->api->get($url, $params);
        return $response;
    }

    public function count($blogId, array $params)
    {
        $url = $this->getMethod('count')->constructUrlWithParams(compact($blogId));
        $response = $this->api->get($url, $params);
        return $response;
    }

    public function get($blogId, $articleId)
    {
        $url = $this->getMethod('get')->constructUrlWithParams(compact($blogId, $articleId));
        $response = $this->api->get($url);
        return $response;
    }

    public function create($blogId, $articleId, $title, array $params)
    {
        $params = array_merge($params, compact($title));
        $url = $this->getMethod('create')->constructUrlWithParams(compact($blogId, $articleId));
        $response = $this->api->post($url, $params);
        return $response;
    }

    public function update($blogId, $articleId, array $params)
    {
        $url = $this->getMethod('update')->constructUrlWithParams(compact($blogId, $articleId));
        $response = $this->api->put($url, $params);
        return $response;
    }

    public function authors()
    {
        $response = $this->api->get($this->getMethod('authors')->getUrl());
        return $response;
    }

    public function tags($blogId, $articleId, array $params)
    {
        $url = $this->getMethod('tags')->constructUrlWithParams(compact($blogId, $articleId));
        $response = $this->api->get($url, $params);
        return $response;
    }

    public function blogTags($blogId, $articleId, array $params)
    {
        $url = $this->getMethod('blogTags')->constructUrlWithParams(compact($blogId, $articleId));
        $response = $this->api->get($url, $params);
        return $response;
    }

    public function remove($blogId, $articleId)
    {
        $url = $this->getMethod('remove')->constructUrlWithParams(compact($blogId, $articleId));
        $response = $this->api->delete($url);
        return $response;
    }
}
