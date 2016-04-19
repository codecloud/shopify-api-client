<?php
namespace CodeCloud\ShopifyApiClient\Event;

class ShopifyStoreWasConfirmed extends Event
{
    /**
     * @var \stdClass
     */
    private $shopifyConfirmation;

    /**
     * @var string
     */
    private $shopUrl;

    /**
     * @param \stdClass $shopifyConfirmation
     */
    public function __construct(\stdClass $shopifyConfirmation, $shopUrl)
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

    /**
     * @return string
     */
    public function getShopUrl()
    {
        return $this->shopUrl;
    }
}