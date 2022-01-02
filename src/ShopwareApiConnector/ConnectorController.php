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
            'base_uri' => $_ENV['shopware_url'],
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
                    'client_id' =>  $_ENV['shopware_client_id'],
                    'client_secret' => $_ENV['shopware_client_secret'],
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