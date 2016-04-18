<?php
namespace CodeCloud\ShopifyApiClient;

use CodeCloud\ShopifyApiClient\EndpointFramework\ApiResponse;
use CodeCloud\ShopifyApiClient\EndpointFramework\EndpointProxy;

class Client
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $httpClient;

    /**
     * @var array
     */
    private $requestDefaults = [
        'headers' => [
            'Content-Type' => 'application/json'
        ]
    ];

    /**
     * @param \GuzzleHttp\Client $httpClient
     */
    public function __construct(\GuzzleHttp\Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $authToken
     */
    public function setAuthKey($authToken)
    {
        $this->requestDefaults = array_merge_recursive($this->requestDefaults, [
            'headers' => [
                'X-Shopify-Auth-Token' => $authToken
            ]
        ]);
    }

    /**
     * @param string $url
     * @param array $params
     * @return ApiResponse
     */
    public function get($url, array $params = [])
    {
        return $this->httpRequest('get', $url, $params);
    }

    /**
     * @param string $url
     * @param array $params
     * @return ApiResponse
     */
    public function put($url, array $params = [])
    {
        return $this->httpRequest('put', $url, $params);
    }

    /**
     * @param string $url
     * @param array $params
     * @return ApiResponse
     */
    public function post($url, array $params = [])
    {
        return $this->httpRequest('post', $url, $params);
    }

    /**
     * @param string $url
     * @param array $params
     * @return ApiResponse
     */
    public function delete($url, array $params = [])
    {
        return $this->httpRequest('delete', $url, $params);
    }

    /**
     * @param string $url
     * @param array $params
     * @return ApiResponse
     */
    public function patch($url, array $params = [])
    {
        return $this->httpRequest('patch', $url, $params);
    }

    /**
     * @param string  $httpVerb
     * @param string $url
     * @param array $params
     * @return ApiResponse
     */
    protected function httpRequest($httpVerb, $url, array $params = [])
    {
        $rawResponse = $this->httpClient->request($httpVerb, $url, $this->mergeOptions(['body' => $params]));

        $data = $rawResponse->getBody()->getContents() ? : json_encode(null);

        return ApiResponse::fromJson($data, $rawResponse->getStatusCode());
    }

    /**
     * @param array $options
     * @return array
     */
    private function mergeOptions(array $options = [])
    {
        return array_merge_recursive($this->requestDefaults, $options);
    }

    /**
     * @return Endpoint\AbandonedCheckouts
     */
    public function abandonedCheckouts()
    {
        return $this->createEndpointProxy('AbandonedCheckouts');
    }

    /**
     * @return Endpoint\Article
     */
    public function article()
    {
        return $this->createEndpointProxy('Article');
    }

    /**
     * @return Endpoint\ApplicationCharge
     */
    public function applicationCharge()
    {
        return $this->createEndpointProxy('ApplicationCharge');
    }

    /**
     * @return Endpoint\Asset
     */
    public function asset()
    {
        return $this->createEndpointProxy('Asset');
    }

    /**
     * @return Endpoint\Blog
     */
    public function blog()
    {
        return $this->createEndpointProxy('Blog');
    }

    /**
     * @return Endpoint\CarrierService
     */
    public function carrierService()
    {
        return $this->createEndpointProxy('CarrierService');
    }

    /**
     * @return Endpoint\CheckoutApi
     */
    public function checkoutApi()
    {
        return $this->createEndpointProxy('CheckoutAPI');
    }

    /**
     * @return Endpoint\Collect
     */
    public function collect()
    {
        return $this->createEndpointProxy('Collect');
    }

    /**
     * @return Endpoint\CustomCollection
     */
    public function customCollection()
    {
        return $this->createEndpointProxy('CustomCollection');
    }

    /**
     * @return Endpoint\Event
     */
    public function event()
    {
        return $this->createEndpointProxy('Event');
    }

    /**
     * @return Endpoint\Metafield
     */
    public function metafield()
    {
        return $this->createEndpointProxy('Metafield');
    }

    /**
     * @return Endpoint\Product
     */
    public function product()
    {
        return $this->createEndpointProxy('Product');
    }

    /**
     * @return Endpoint\ScriptTag
     */
    public function scriptTag()
    {
        return $this->createEndpointProxy('ScriptTag');
    }

    /**
     * @return Endpoint\Shop
     */
    public function shop()
    {
        return $this->createEndpointProxy('Shop');
    }

    /**
     * @return Endpoint\SmartCollection
     */
    public function smartCollection()
    {
        return $this->createEndpointProxy('SmartCollection');
    }

    /**
     * @return Endpoint\Theme
     */
    public function theme()
    {
        return $this->createEndpointProxy('Theme');
    }

    /**
     * @return Endpoint\Webhook
     */
    public function webhook()
    {
        return $this->createEndpointProxy('Webhook');
    }

    /**
     * @param string $endpointName
     * @return EndpointProxy
     */
    private function createEndpointProxy($endpointName)
    {
        return EndpointProxy::create($endpointName, $this);
    }
}

