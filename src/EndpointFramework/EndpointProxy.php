<?php
namespace Codecloud\ShopifyApiClient\EndpointFramework;

use Codecloud\ShopifyApiClient\Client;
use Codecloud\ShopifyApiClient\Endpoint\Endpoint;

class EndpointProxy
{
    /**
     * @var EndpointDefinition
     */
    private $endpointDefinition;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * @var Endpoint
     */
    private $endpoint;

    /**
     * @param EndpointDefinition  $endpointDefinition
     * @param MethodCallValidator $validator
     * @param Endpoint            $endpoint
     */
    public function __construct(EndpointDefinition $endpointDefinition, MethodCallValidator $validator, Endpoint $endpoint)
    {
        $this->endpointDefinition = $endpointDefinition;
        $this->validator = $validator;
        $this->endpoint = $endpoint;
    }

    /**
     * @param string $methodName
     * @param array $args
     * @return mixed
     * @throws \Exception
     */
    public function __call($methodName, $args)
    {
        if (! $method = $this->endpointDefinition->getMethod($methodName)) {
            throw new \Exception('The "' . $this->endpointDefinition->getName() . '" endpoint does not have a "' . $methodName . '" method');
        }

        $validateArgs = array_merge([$method], $args);

        //perform some validation
        call_user_func_array([$this->validator, 'validateMethodCall'], $validateArgs);

        //validation passed, so let's go ahead and make the API call
        return call_user_func_array([$this->endpoint, $method->getName()], $args);
    }

    /**
     * @param string $endpointName
     * @param Client $apiClient
     * @return EndpointProxy
     */
    public static function create($endpointName, Client $apiClient)
    {
        $endpointConfig = __DIR__ . '/../../config/endpoints/' . $endpointName . '.yaml';

        $nsRoot = 'Codecloud\ShopifyApiClient\Endpoint\\';

        $endpointClass = $nsRoot . $endpointName;
        $endpointDefinition = EndpointDefinition::fromYaml($endpointConfig);

        $endpoint  = new $endpointClass($apiClient);
        $validator = new MethodCallValidator();

        return new self($endpointDefinition, $validator, $endpoint);
    }
}