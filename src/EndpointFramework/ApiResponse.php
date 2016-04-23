<?php
namespace CodeCloud\ShopifyApiClient\EndpointFramework;

class ApiResponse
{
    /**
     * @var \stdClass
     */
    private $raw;

    /**
     * @var int
     */
    private $httpStatus;

    /**
     * @param \stdClass $rawResponse
     * @param int $httpStatus
     */
    public function __construct(\stdClass $rawResponse, $httpStatus)
    {
        $this->raw = $rawResponse;
        $this->httpStatus = $httpStatus;
    }

    /**
     * @param string $property
     * @param null|mixed $default
     * @return mixed
     */
    public function get($property, $default = null)
    {
        if (! property_exists($this->raw, $property)) {
            return $default;
        }

        return $this->raw->$property;
    }

    /**
     * @return bool
     */
    public function success()
    {
        return $this->httpStatus >= 200 && $this->httpStatus < 300;
    }

    /**
     * @param string $jsonString
     * @param integer $httpStatus
     * @return ApiResponse
     * @throws \Exception
     */
    public static function fromJson($jsonString, $httpStatus)
    {
        if (! $decoded = json_decode($jsonString)) {
            throw new \Exception('Could not JSON decode string: ' . $jsonString);
        }

        return new self($decoded, $httpStatus);
    }
}