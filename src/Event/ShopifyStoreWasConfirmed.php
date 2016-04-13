<?php
namespace Codecloud\ShopifyApiClient\Event;

class ShopifyStoreWasConfirmed extends Event
{
    /**
     * @var \stdClass
     */
    private $shopifyConfirmation;

    /**
     * @param \stdClass $shopifyConfirmation
     */
    public function __construct(\stdClass $shopifyConfirmation)
    {
        $this->shopifyConfirmation = $shopifyConfirmation;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->shopifyConfirmation->access_token;
    }
}