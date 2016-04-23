<?php

namespace CodeCloud\ShopifyApiClient\Endpoint;

class RecurringApplicationCharge extends Endpoint
{
    public function create($name, $price, array $params)
    {
        $params = array_merge($params, compact($name, $price));
        $response = $this->api->post($this->getMethod('create')->getUrl(), $params);
        return $response->get('recurring_application_charge');
    }

    public function get($recurringApplicationChargeId, array $params)
    {
        $url = $this->getMethod('get')->constructUrlWithParams(compact($recurringApplicationChargeId));
        $response = $this->api->get($url, $params);
        return $response->get('recurring_application_charge');
    }

    public function search(array $params)
    {
        $response = $this->api->get($this->getMethod('search')->getUrl(), $params);
        return $response->get('recurring_application_charges');
    }

    public function activate($recurringApplicationChargeId, array $params)
    {
        $url = $this->getMethod('activate')->constructUrlWithParams(compact($recurringApplicationChargeId));
        $response = $this->api->post($url, $params);
        return $response->get('recurring_application_charge');
    }

    public function cancel($recurringApplicationChargeId)
    {
        $url = $this->getMethod('cancel')->constructUrlWithParams(compact($recurringApplicationChargeId));
        $response = $this->api->delete($url);
        return $response->success();
    }

    public function customise($recurringApplicationChargeId, array $params)
    {
        $url = $this->getMethod('customise')->constructUrlWithParams(compact($recurringApplicationChargeId));
        $response = $this->api->put($url, $params);
        return $response->get('recurring_application_charge');
    }
}
