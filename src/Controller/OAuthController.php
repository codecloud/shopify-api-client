<?php
namespace Codecloud\ShopifyApiClient\Controller;

use Codecloud\ShopifyApiClient\Auth\HmacSignature;
use Codecloud\ShopifyApiClient\Auth\Nonce;
use Codecloud\ShopifyApiClient\Auth\RequestAuthenticator;
use Codecloud\ShopifyApiClient\Event\ShopifyStoreWasConfirmed;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Event;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\Routing\Exception\InvalidParameterException;

class OAuthController extends Controller
{
    public function getInstallApp(Request $request)
    {
        if (! $shop = $request->get('shop')) {
            throw new InvalidParameterException('Shop is a required parameter');
        }

        $clientId = \Config::get('shopify.api_key');
        $scopes   = \Config::get('shopify.scopes');
        $redirectUri = \Config::get('shopify.redirect_uri');
        $state = (new Nonce())->generateAndPersist();

        $url = "https://$shop.myshopify.com/admin/oauth/authorize?client_id=$clientId&scope=$scopes&redirect_uri=$redirectUri&state=$state";

        Response::create('', 302, [
            'Location' => $url
        ])->send();
    }

    public function getConfirmInstallation(Request $request)
    {
        $code = $request->get('code');
        $shop = $request->get('shop');

        $requestAuthenticator = new RequestAuthenticator(new HmacSignature());

        if ($requestAuthenticator->authenticates($request)) {
            throw new AccessDeniedException('Invalid parameters were passed to confirm the app installation');
        }

        if ($request->get('nonce') != (new Nonce())->retrieve()) {
            throw new AccessDeniedException('Invalid nonce');
        }

        if (! preg_match('/^[0-9A-Za-z-\.]+\.myshopify\.com$/', $shop)) {
            throw new InvalidParameterException('Invalid shop name "' . $shop . '"');
        }

        $url = "https://$shop.myshopify.com/admin/oauth/access_token";

        $response = (new Client())->post($url, [
            'body' => [
                'client_id' => \Config::get('shopify.keys.api_key'),
                'client_secret' => \Config::get('shopify.keys.secret_key'),
                'code' => $code
            ]
        ]);

        $decoded = $response->getBody()->getContents();

        //do something here
        Event::fire(new ShopifyStoreWasConfirmed($decoded));

        Response::create('', 302, [
            'Location' => \Config::get('shopify.post_install_redirect_uri')
        ])->send();
    }
}