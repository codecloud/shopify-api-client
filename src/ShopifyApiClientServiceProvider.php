<?php
namespace CodeCloud\ShopifyApiClient;

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
    }

    /**
     * @return string
     */
    private function getLaravelConfigPath()
    {
        return __DIR__ . '/../laravel-config/shopify-api-client.php';
    }
}