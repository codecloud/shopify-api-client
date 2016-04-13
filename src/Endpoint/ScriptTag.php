<?php

namespace Codecloud\ShopifyApiClient\Endpoint;

class ScriptTag extends Endpoint
{
    public function search(array $params)
    {
        $response = $this->api->get($this->getMethod('search')->getUrl(), $params);
        return $response->get('script_tags');
    }

    public function count(array $params)
    {
        $response = $this->api->get($this->getMethod('count')->getUrl(), $params);
        return $response->get('count');
    }

    public function get($scriptTagId, array $params)
    {
        $url = $this->getMethod('get')->constructUrlWithParams(compact($scriptTagId));
        $response = $this->api->get($url, $params);
        return $response->get('script_tag');
    }

    public function create($event, $src, array $params)
    {
        $params = array_merge($params, compact($event, $src));
        $response = $this->api->post($this->getMethod('create')->getUrl(), $params);
        return $response->get('script_tag');
    }

    public function update($scriptTagId, $event, $src, array $params)
    {
        $params = array_merge($params, compact($event, $src));
        $url = $this->getMethod('update')->constructUrlWithParams(compact($scriptTagId));
        $response = $this->api->put($url, $params);
        return $response->get('script_tag');
    }

    public function delete($scriptTagId)
    {
        $url = $this->getMethod('delete')->constructUrlWithParams(compact($scriptTagId));
        $response = $this->api->delete($url);
        return $response;
    }
}
