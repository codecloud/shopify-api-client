<?php
namespace Codecloud\ShopifyApiClient\Auth;

class Nonce
{
    /**
     * @var stirng
     */
    private $peristenceKey = 'shopify-nonce';

    /**
     * @return string
     */
    public function generateAndPersist()
    {
        $nonce = $this->generate();
        \Session::set($this->peristenceKey, $nonce);
        return $nonce;
    }

    /**
     * @return string
     */
    public function retrieve()
    {
        return \Session::get($this->peristenceKey);
    }

    /**
     * @return string
     */
    private function generate()
    {
        return md5(uniqid('nonce-', true));
    }
}