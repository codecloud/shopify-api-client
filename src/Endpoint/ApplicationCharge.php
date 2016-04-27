<?php

namespace CodeCloud\ShopifyApiClient\Endpoint;

class ApplicationCharge extends Endpoint
{
    public function create($name, $price, array $params)
    {
        $params = array_merge($params, compact($name, $price));
        $response = $this->api->post($this->getMethod('create')->getUrl(), $params);
        return $response->success();
    }

    public function get($applicationChargeId, array $params)
    {
        $url = $this->getMethod('get')->constructUrlWithParams(compact($applicationChargeId));
        $response = $this->api->get($url, $params);
        return $response->get('application_charge');
    }

    public function search(array $params)
    {
        $response = $this->api->get($this->getMethod('search')->getUrl(), $params);
        return $response->get('application_charges');
    }

    public function activate($applicationChargeId)
    {
        $params = ['application_charge' => $params];
        $url = $this->getMethod('activate')->constructUrlWithParams(compact($applicationChargeId));
        $response = $this->api->post($url);
        return $response->get('application_charge');
    }
}
