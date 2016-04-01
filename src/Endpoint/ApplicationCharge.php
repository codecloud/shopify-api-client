<?php
namespace Codecloud\ShopifyApiClient\Endpoint;

class ApplicationCharge extends Endpoint
{
    /**
     * @param array $params
     */
    public function create(array $params)
    {
        return $this->call(self::POST, 'application_charges', [
            'name'       => 'required|string',
            'price'      => 'required|currency',
            'return_url' => 'string',
            'test'       => 'bool'
        ]);
    }

    public function get($applicationChargeId)
    {
        return $this->callSingle(self::GET, 'application_charges/' . $id, 'application_charge', [
            'fields' => 'string'
        ]);
    }

    public function search()
    {
        return $this->call(self::GET, 'application_charges', [
            'since_id' => 'int',
            'fields'   => 'string'
        ]);
    }

    public function activate($applicationChargeId)
    {
        return $this->callSingle(self::POST, 'application_charges/' . $id . '/activate', 'application_charge');
    }
}