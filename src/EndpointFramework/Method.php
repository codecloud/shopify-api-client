<?php
namespace Codecloud\ShopifyApiClient\EndpointFramework;

class Method
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $httpVerb;

    private $urlParams = [];

    private $allowedParams = [];

    private $returnsSingleProperty;

    /**
     * @param string $name
     * @param string $url
     * @param string $httpVerb
     */
    public function __construct($name, $url, $httpVerb)
    {
        $this->name = $name;
        $this->url = $url;
        $this->httpVerb = $httpVerb;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @param array $allowedParams
     */
    public function setAllowedParams(array $allowedParams)
    {
        $this->allowedParams = $allowedParams;
    }

    /**
     * @param string $propertyName
     */
    public function setReturnsSingleProperty($propertyName)
    {
        $this->returnsSingleProperty = $propertyName;
    }

    /**
     * @param \stdClass $response
     * @return mixed
     */
    public function getReturnValueFromResponse(\stdClass $response)
    {
        if ($this->returnsSingleProperty && property_exists($response, $this->returnsSingleProperty)) {
            return $response->{$this->returnsSingleProperty};
        }

        return $response;
    }

    /**
     * @return array
     */
    public function getUrlParams()
    {
        return $this->urlParams;
    }

    /**
     * @param string $paramName
     * @param array|string $paramConfig
     */
    public function addUrlParam($paramName, $paramConfig)
    {
        $this->urlParams[$paramName] = $paramConfig;
    }

    /**
     * @return array
     */
    public function getRequiredParams()
    {
        return array_filter($this->allowedParams, function($paramConfig) {
            return ! empty($paramConfig['required']);
        });
    }

    /**
     * @param string $paramName
     * @param array|string $paramConfig
     */
    public function addAllowedParam($paramName, $paramConfig)
    {
        $this->allowedParams[$paramName] = $paramConfig;
    }

    /**
     * @param string $paramName
     * @return mixed
     * @throws \Exception
     */
    public function getOptionalParamConfig($paramName)
    {
        if (! array_key_exists($paramName, $this->allowedParams)) {
            throw new \Exception('Param "' . $paramName . '" is not an allowable parameter on method "' . $this->getName() . '"');
        }

        return $this->allowedParams[$paramName];
    }

    /**
     * @param array $params
     * @return string
     */
    public function constructUrlWithParams(array $params)
    {
        $url = $this->url;

        foreach ($params as $paramName => $value) {
            $url = str_replace('{' . $paramName . '}', $value, $url);
        }

        return $url;
    }

    /**
     * @param string $methodName
     * @param array $methodDefinition
     * @return $this
     */
    public static function fromArray($methodName, array $methodDefinition)
    {
        $method = new self($methodName, $methodDefinition['url'], $methodDefinition['type']);

        if (! empty($methodDefinition['url_params'])) {
            foreach ($methodDefinition['url_params'] as $paramName => $paramConfig) {
                $method->addUrlParam($paramName, $paramConfig);
            }
        }

        if (! empty($methodDefinition['allow'])) {
            foreach ($methodDefinition['allow'] as $paramName => $paramConfig) {
                $method->addAllowedParam($paramName, $paramConfig);
            }
        }

        if (! empty($methodDefinition['returns'])) {
            $method->setReturnsSingleProperty($methodDefinition['returns']);
        }

        return $method;
    }
}