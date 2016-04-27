<?php

namespace CodeCloud\ShopifyApiClient\Endpoint;

class CarrierService extends Endpoint
{
    public function create(array $params)
    {
        $params = ['carrier_service' => $params];
        $response = $this->api->post($this->getMethod('create')->getUrl(), $params);
        return $response->get('carrier_service');
    }

    public function update($carrierServiceId, array $params)
    {
        $params = ['carrier_service' => $params];
        $url = $this->getMethod('update')->constructUrlWithParams(compact('carrierServiceId'));
        $response = $this->api->put($url, $params);
        return $response->get('carrier_service');
    }

    public function search()
    {
        $response = $this->api->get($this->getMethod('search')->getUrl());
        return $response->get('carrier_services');
    }

    public function get($carrierServiceId)
    {
        $url = $this->getMethod('get')->constructUrlWithParams(compact('carrierServiceId'));
        $response = $this->api->get($url);
        return $response->get('carrier_service');
    }

    public function delete($carrierServiceId)
    {
        $url = $this->getMethod('delete')->constructUrlWithParams(compact('carrierServiceId'));
        $response = $this->api->delete($url);
        return $response;
    }
}
