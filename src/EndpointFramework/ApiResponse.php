<?php
namespace Codecloud\ShopifyApiClient\EndpointFramework;

class ApiResponse
{
    /**
     * @var \stdClass
     */
    private $raw;

    /**
     * @param \stdClass $rawResponse
     */
    public function __construct(\stdClass $rawResponse)
    {
        $this->raw = $rawResponse;
    }

    /**
     * @param string $property
     * @param null|mixed $default
     * @return mixed
     */
    public function get($property, $default = null)
    {
        if (! property_exists($property, $this->raw)) {
            return $default;
        }

        return $this->raw->$property;
    }

    /**
     * @param string $jsonString
     * @return ApiResponse
     * @throws \Exception
     */
    public static function fromJson($jsonString)
    {
        if (! $decoded = json_decode($jsonString)) {
            throw new \Exception('Could not JSON decode string: ' . $jsonString);
        }

        return new self($decoded);
    }
}