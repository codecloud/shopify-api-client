<?php
namespace Codecloud\ShopifyApiClient\Endpoint;

use Codecloud\ShopifyApiClient\Client;
use Codecloud\ShopifyApiClient\EndpointFramework\Method;
use Symfony\Component\Yaml\Yaml;

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
     * @var Client
     */
    protected $api;

    /**
     * @param Client $apiClient
     */
    public function __construct(Client $apiClient)
    {
        $this->api = $apiClient;
    }

    /**
     * @param string $methodName
     * @return Method
     * @throws \Exception
     */
    protected function getMethod($methodName)
    {
        if (! array_key_exists($methodName, $this->getEndpointMethods())) {
            throw new \Exception('Method "' . $methodName . '" does not exist on endpoint "' . get_class($this) . '"');
        }

        return $this->endpointMethods[$methodName];
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
                $parsed     = Yaml::parse(file_get_contents($file->getRealPath()), true, true);

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
