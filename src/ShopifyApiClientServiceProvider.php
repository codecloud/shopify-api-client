<?php
namespace CodeCloud\ShopifyApiClient;

use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;

class ShopifyApiClientServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            $this->getLaravelConfigPath() => config_path('shopify-api-client.php')
        ]);
    }

    public function register()
    {
        if (! $this->app->routesAreCached()) {
            $this->registerRoutes();
        }
    }

    private function registerRoutes()
    {
        $urls = \Config::get('shopify-api-client.urls');

        $controller = __NAMESPACE__ . '\\Controller\\OAuthController';

        Route::get($urls['begin'], "$controller@getInstallApp");
        Route::get($urls['confirm_installation'], "$controller@getConfirmInstallation");
    }

    /**
     * @return string
     */
    private function getLaravelConfigPath()
    {
        return __DIR__ . '/../laravel-config/shopify-api-client.php';
    }
}