<?php
return [
    'urls' => [
        'install'                   => env('APP_URL') . '/shopify-install/begin',
        'confirm_installation'      => env('APP_URL') . '/shopify-install/confirm',
        'post_install_redirect_uri' => env('APP_URL') . '/shopify-install/complete'
    ],
    'keys' => [
        'api_key'    => '',
        'secret_key' => ''
    ],
    'scopes' => [
        'read_content',
        'write_content',
        'read_themes',
        'write_themes',
        'read_products',
        'write_products',
        'read_customers',
        'write_customers',
        'read_orders',
        'write_orders',
        'read_script_tags',
        'write_script_tags',
        'read_fulfillments',
        'write_fulfillments',
        'read_shipping',
        'write_shipping',
        'read_analytics',
        'read_users',
        'write_users'
    ]
];