<?php
namespace CodeCloud\ShopifyApiClient\EndpointFramework;

use Symfony\Component\Yaml\Yaml;

class EndpointDefinition
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Method[]
     */
    private $methods;

    /**
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param Method $method
     */
    public function addMethod(Method $method)
    {
        $this->methods[$method->getName()] = $method;
    }

    /**
     * @param string $methodName
     * @return bool
     */
    public function hasMethod($methodName)
    {
        return array_key_exists($methodName, $this->methods);
    }

    /**
     * @param string $methodName
     * @return Method
     */
    public function getMethod($methodName)
    {
        if (! $this->hasMethod($methodName)) {
            return false;
        }
        
        return $this->methods[$methodName];
    }

    /**
     * @param string $filePath
     * @return $this
     */
    public static function fromYaml($filePath)
    {
        $yaml = Yaml::parse(file_get_contents($filePath));
        $definition = new self(basename($filePath, '.yaml'));

        foreach ($yaml as $methodName => $methodDefinition) {
            $method = Method::fromArray($methodName, $methodDefinition);
            $definition->addMethod($method);
        }

        return $definition;
    }
}