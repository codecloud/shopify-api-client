<?php
namespace CodeCloud\ShopifyApiClient\EndpointFramework;

class MethodCallValidator
{

    /**
     * @param Method $method
     * @param mixed  $args
     * @throws ValidationException
     */
    public function validateMethodCall(Method $method, ...$args)
    {
        $argCount = count($args);

        $urlParams = $method->getUrlParams();

        foreach ($urlParams as $paramName => $paramConfig) {
            $this->validate($paramName, $paramConfig, array_shift($args), true);
        }

        foreach ($method->getRequiredParams() as $paramName => $paramConfig) {
            $this->validate($paramName, $paramConfig, array_shift($args), true);
        }

        //if there are no more args remaining, we can return immediately
        if (! $args) {
            return;
        }

        if (count($args) != 1) {
            throw new \InvalidArgumentException('An incorrect number of parameters were specified [' . $argCount . ']');
        }

        foreach (array_shift($args) as $optionalParamName => $optionalParamValue) {
            $paramConfig = $method->getOptionalParamConfig($optionalParamName);
            $this->validate($optionalParamName, $paramConfig, $optionalParamValue);
        }
    }

    /**
     * @param string $paramName
     * @param array|string $paramConfig
     * @param mixed $value
     * @param null|bool $required
     * @throws ValidationException
     */
    private function validate($paramName, $paramConfig, $value, $required = null)
    {
        if (($required || ! empty($paramConfig['required'])) && ! $this->isNotEmpty($value)) {
            throw new ValidationException('[' . $paramName . '] is a required parameter');
        }

        $type = is_string($paramConfig) ? $paramConfig : $paramConfig['type'];
        $methodName = 'isValid' . ucfirst($type);

        if ($this->$methodName($value, $paramConfig) !== true) {
            throw new ValidationException('Param "' . $paramName . '" (' . $type . ') has been specified with an invalid value "' . $value . '"');
        }
    }

    private function isValidInt($value, $paramConfig = null)
    {
        return ! preg_match('/[^0-9]/', $value);
    }

    private function isNotEmpty($value, $paramConfig = null)
    {
        return ! empty($value);
    }

    private function isValidDatetime($value, $paramConfig = null)
    {
        return preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}/', $value);
    }

    private function isValidString($value, $paramConfig = null)
    {
        return true;
    }

    private function isValidCurrency($value, $paramConfig = null)
    {
        return is_numeric($value);
    }

    private function isValidEnum($value, $paramConfig = null)
    {
        return in_array($value, $paramConfig['options']);
    }

    private function isValidBoolean($value)
    {
        return is_bool($value);
    }
}