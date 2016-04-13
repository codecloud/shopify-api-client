<?php

namespace Codecloud\ShopifyApiClient\Endpoint;

class Webhook extends Endpoint
{
    public function search(array $params)
    {
        $response = $this->api->get($this->getMethod('search')->getUrl(), $params);
        return $response->get('webhooks');
    }

    public function count(array $params)
    {
        $response = $this->api->get($this->getMethod('count')->getUrl(), $params);
        return $response->get('count');
    }

    public function get($webhookId, array $params)
    {
        $url = $this->getMethod('get')->constructUrlWithParams(compact($webhookId));
        $response = $this->api->get($url, $params);
        return $response->get('webhook');
    }

    public function create($topic, $address, array $params)
    {
        $params = array_merge($params, compact($topic, $address));
        $response = $this->api->post($this->getMethod('create')->getUrl(), $params);
        return $response->get('webhook');
    }

    public function update($webhookId, array $params)
    {
        $url = $this->getMethod('update')->constructUrlWithParams(compact($webhookId));
        $response = $this->api->put($url, $params);
        return $response->get('webhook');
    }

    public function delete($webhookId)
    {
        $url = $this->getMethod('delete')->constructUrlWithParams(compact($webhookId));
        $response = $this->api->delete($url);
        return $response;
    }
}
