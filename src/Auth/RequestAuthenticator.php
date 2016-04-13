<?php
namespace Codecloud\ShopifyApiClient\Auth;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;

class RequestAuthenticator
{
    /**
     * @param HmacSignature $signatureGenerator
     */
    public function __construct(HmacSignature $signatureGenerator)
    {
        $this->signatureGenerator = $signatureGenerator;
    }

    /**
     * @param Request $request
     * @return boolean
     */
    public function authenticates(Request $request)
    {
        $params = [
            'timestamp' => $request->get('timestamp'),
            'shop'      => $request->get('shop')
        ];

        if ($params['timestamp'] < time() - 60) {
            throw new AccessDeniedException('Request is too old. [' . $params['timestamp'] . ']');
        }

        $this->signatureGenerator->setParams($params);

        return $this->signatureGenerator->generateHmac() === $request->get('hmac');
    }
}