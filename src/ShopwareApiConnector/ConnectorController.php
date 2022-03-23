<?php

namespace ShopwareApiConnector;

use GuzzleHttp\Client;
use JsonException;

class ConnectorController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->restClient = new Client([
            'base_uri' => $_ENV['S'],
            'headers' => ['Content-Type' => 'application/json'],
        ]);
    }

    /**
     * @throws JsonException
     */
    function getAuthToken() {

        $token = $this->restClient->post(
            '/api/oauth/token',
            [
                'body' => json_encode([
                    'client_id' =>  $_ENV['SHOPWARE_CLIENT_ID'],
                    'client_secret' => $_ENV['SHOPWARE_CLIENT_SECRET'],
                    'grant_type' => 'client_credentials',
                ]),
            ]
        );
        return json_decode($token->getBody()->getContents(), true);
    }


    /**
     * @throws JsonException
     */
    public function postData($urlslug, $body) : array
    {

        $token = $this->getAuthToken();

        $headers = [
            'Authorization' => $token['token_type'] . ' ' . $token['access_token'],
            'Accept' => 'application/json',
        ];

        $response = $this->restClient->post($urlslug, [
            'headers' => $headers,
            'json' => json_encode($body)
        ]);

        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }





}
