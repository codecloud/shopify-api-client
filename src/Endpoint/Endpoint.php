<?php
namespace Codecloud\ShopifyApiClient\Endpoint;

abstract class Endpoint
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';

    /**
     * @var array
     */
    private $endpointMethods = [];

    /**
     * @param string $httpVerb
     * @param string $url
     * @param array $validParams
     * @param array $params
     */
    protected function call($httpVerb, $url, array $validParams = [], array $params = [])
    {

    }

    /**
     * @param string $httpVerb
     * @param string $url
     * @param string $field
     * @param array $validParams
     * @param array $params
     * @return mixed
     */
    protected function callSingle($httpVerb, $url, $field, array $validParams = [], array $params = [])
    {
        $response = $this->call($httpVerb, $url, $validParams, $params);
        return $response->$field;
    }

    /**
     * @param string $url
     * @param array $validParams
     * @param array $params
     * @return int
     */
    protected function callCount($url, array $validParams = [], array $params = [])
    {
        return (int)$this->singleResult(self::GET, $url, 'count', $validParams, $params);
    }

    /**
     * @param string $methodName
     * @param array $args
     * @throws ValidationException
     * @throws \Exception
     */
    public function __call($methodName, array $args)
    {
        if (! array_key_exists($methodName, $this->getEndpointMethods())) {
            throw new \Exception($methodName . ' is not a valid method on the ' . get_class($this) . ' endpoint');
        }

        //validate the parameters against the definition we hold for the endpoint's method
        call_user_func_array([$this, 'validate'], [$methodName, $args]);

        $config = $this->getEndpointMethods()[$methodName];

        $httpVerb = $config['type'];

        $url = $config['url'];

        //validate any URL parameters first. These will always be required parameters
        if (! empty($config['url_params'])) {
            foreach ($config['url_params'] as $paramName => $paramConfig) {
                $this->validateRequired($paramConfig['type'], array_shift($methodArgs), $paramName);
            }
        }

        array_unshift($args, $url);

        //if we got this far, the params provided match one of the endpoint method definitions
        $response = call_user_func_array([$this->api, $httpVerb], [$url, $args]);

        if (! empty($config['returns'])) {
            if (! property_exists($response, $config['returns'])) {
                throw new ResponseException('Property [' . $config['returns'] . '] was not present in the response');
            }

            return $response->{$config['returns']};
        }
    }

    private function validate($methodName, $args)
    {
        $methodName = func_get_arg(0);
        $methodArgs = array_slice(func_get_args(), 1);

        $config = $this->getEndpointMethods()[$methodName];

        //validate any URL parameters first. These will always be required parameters
        if (! empty($config['url_params'])) {
            foreach ($config['url_params'] as $paramName => $paramConfig) {
                $this->validateRequired($paramConfig['type'], array_shift($methodArgs), $paramName);
            }
        }

        $kwParams = [];

        //validate any required parameters next
        if (! empty($config['allow'])) {
            foreach ($config['allow'] as $paramName => $paramConfig) {
                $type = is_string($paramConfig) ? $paramConfig : $paramConfig['type'];

                if (! empty($paramConfig['required'])) {
                    $this->validateRequired($type, array_shift($methodArgs), $paramName);
                } else {
                    $kwParams[$paramName] = $paramConfig;
                }
            }
        }

        //if we have no more args, return
        if (! $methodArgs) {
            return;
        }

        //if we have more than 1 arg remaining, there's probably some issue with the number of
        //args being passed here, and most likely user error
        if (count($methodArgs) > 1) {
            throw new ValidationException('Too many arguments were provided for ' . $methodName);
        }

        //if the method has additional non-required parameters, validate them against their expected types
        $kwArgs = array_unshift($methodArgs);

        if (! is_array($kwArgs)) {
            throw new \InvalidArgumentException('Expected an array of optional parameters but got ' . gettype($kwArgs));
        }

        foreach ($kwArgs as $name => $value) {
            $this->validateVar($paramConfig[$name], $value, $name);
        }
    }

    /**
     * @param string|array $paramConfig
     * @param mixed $value
     * @param string $name
     * @throws ValidationException
     */
    private function validateRequired($paramConfig, $value, $name)
    {
        $type = is_string($paramConfig) ? $paramConfig : $paramConfig['type'];

        if (! $value) {
            throw new ValidationException($name . ' is required');
        }

        $this->validateVar($type, $value, $name);
    }

    /**
     * @param array|string paramConfig
     * @param mixed $value
     * @param string $name
     * @throws ValidationException
     */
    private function validateVar($paramConfig, $value, $name)
    {
        $type = is_string($paramConfig) ? $paramConfig : $paramConfig['type'];

        switch ($type) {
            case 'int':
                $valid = ! preg_match('/[^0-9]/', $value);
                break;
            case 'DateTime':
                $valid = preg_match('/^[\d]{4}-[\d]{2}-[\d]{2} [\d]{2}:[\d]{2}:[\d]{2}/', $value);
                break;
            case 'enum':
                $valid = in_array($value, $paramConfig['options']);
                break;
            case 'currency':
                $valid = is_numeric($value);
                break;
            default:
                $valid = true;
        }

        if (! $valid) {
            throw new ValidationException($name . ' is not a valid ' . $type . ' [' . $value . ']');
        }
    }

    /**
     * @return array
     */
    private function getEndpointMethods()
    {
        if (! $this->endpointMethods) {
            /** @var \SplFileInfo $file */
            foreach ($this->getConfigFiles() as $file) {
                $configName = $file->getBasename('.yaml');
                $parsed     = $this->yamlParser->parse(file_get_contents($file->getRealPath()), true, true);

                $this->endpointMethods[$configName] = $parsed;
            }
        }

        return $this->endpointMethods;
    }

    /**
     * @return \Generator
     */
    private function getConfigFiles()
    {
        $dir = new \DirectoryIterator(__DIR__ . '/../../config/endpoints');

        foreach ($dir as $entry) {
            if ($entry->getExtension() != 'yaml') {
                continue;
            }

            yield $entry;
        }
    }
}
