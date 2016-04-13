<?php

namespace Codecloud\ShopifyApiClient\Endpoint;

class Asset extends Endpoint
{
    public function search($themeId)
    {
        $url = $this->getMethod('search')->constructUrlWithParams(compact($themeId));
        $response = $this->api->get($url);
        return $response;
    }

    public function get($themeId, array $params)
    {
        $url = $this->getMethod('get')->constructUrlWithParams(compact($themeId));
        $response = $this->api->get($url, $params);
        return $response;
    }

    public function put($themeId, object $asset)
    {
        $params = array_merge($params, compact($asset));
        $url = $this->getMethod('put')->constructUrlWithParams(compact($themeId));
        $response = $this->api->put($url);
        return $response;
    }

    public function delete($themeId, $asset[key])
    {
        $params = array_merge($params, compact($asset[key]));
        $url = $this->getMethod('delete')->constructUrlWithParams(compact($themeId));
        $response = $this->api->delete($url);
        return $response;
    }
}
