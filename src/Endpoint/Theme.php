<?php

namespace CodeCloud\ShopifyApiClient\Endpoint;

class Theme extends Endpoint
{
    public function search(array $params)
    {
        $response = $this->api->get($this->getMethod('search')->getUrl(), $params);
        return $response->get('themes');
    }

    public function get($themeId, array $params)
    {
        $url = $this->getMethod('get')->constructUrlWithParams(compact($themeId));
        $response = $this->api->get($url, $params);
        return $response->get('theme');
    }

    public function create($name, array $params)
    {
        $params = array_merge($params, compact($name));
        $response = $this->api->post($this->getMethod('create')->getUrl(), $params);
        return $response;
    }

    public function update($themeId, array $params)
    {
        $url = $this->getMethod('update')->constructUrlWithParams(compact($themeId));
        $response = $this->api->put($url, $params);
        return $response->get('theme');
    }
}
