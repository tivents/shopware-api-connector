<?php

namespace ShopwareApiConnector;

use Vin\ShopwareSdk\Client\GrantType\ClientCredentialsGrantType;
use Vin\ShopwareSdk\Client\GrantType\PasswordGrantType;

class BaseController
{

    public function __construct()
    {

    }

    function getGrantType(): PasswordGrantType|ClientCredentialsGrantType
    {

        $grantType = match($_ENV['SHOPWARE_AUTH_METHOD']) {
            'password_grant' =>  new PasswordGrantType($_ENV['SHOPWARE_USER_NAME'], $_ENV['SHOPWARE_USER_PASSWORD']),
            'client_crediantials' => new ClientCredentialsGrantType($_ENV['SHOPWARE_CLIENT_ID'], $_ENV['SHOPWARE_CLIENT_SECRET']),
        };

        return $grantType;
    }
}
