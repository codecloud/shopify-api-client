<?php
namespace CodeCloud\ShopifyApiClient\Controller;

use CodeCloud\ShopifyApiClient\Auth\HmacSignature;
use CodeCloud\ShopifyApiClient\Auth\Nonce;
use CodeCloud\ShopifyApiClient\Auth\RequestAuthenticator;
use CodeCloud\ShopifyApiClient\Event\ShopifyStoreWasConfirmed;
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

        $clientId = \Config::get('shopify-api-client.keys.api_key');
        $scopes   = implode(',', \Config::get('shopify-api-client.scopes'));
        $redirectUri = \Config::get('shopify-api-client.urls.confirm_installation');
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
                'client_id' => \Config::get('shopify-api-client.keys.api_key'),
                'client_secret' => \Config::get('shopify-api-client.keys.secret_key'),
                'code' => $code
            ]
        ]);

        $decoded = $response->getBody()->getContents();

        //do something here
        Event::fire(new ShopifyStoreWasConfirmed($decoded));

        Response::create('', 302, [
            'Location' => \Config::get('shopify-api-client.urls.post_install_redirect_uri')
        ])->send();
    }
}