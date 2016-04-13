<?php
namespace CodeCloud\ShopifyApiClient\Auth;

class HmacSignature
{
    /**
     * @var string
     */
    private $sharedSecret;

    /**
     * @var array
     */
    private $params = [];

    /**
     * @var array
     */
    private $ignoreKeys = ['hmac', 'signature'];

    /**
     * @param string $sharedSecret
     * @param array $params
     */
    public function __construct($sharedSecret, array $params = [])
    {
        $this->sharedSecret = $sharedSecret;
        $this->setParams($params);
    }

    /**
     * @return string
     */
    public function generateHmac()
    {
        $signatureParts = array();

        foreach ($this->params as $key => $value) {
            if (in_array($key, $this->ignoreKeys)) {
                continue;
            }

            $signatureParts[] = $key . '=' . $value;
        }

        natsort($signatureParts);

        return hash_hmac('sha256', implode('&', $signatureParts), $this->sharedSecret);
    }

    /**
     * @param array $params
     * @return $this
     */
    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->generateHmac();
    }
}