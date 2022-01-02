<?php

namespace ShopwareApiConnector;

use GuzzleHttp\Psr7\Request;
use JsonException;

class ConnectorController extends BaseController
{
    /**
     * @throws JsonException
     */
    function getAuthToken() {
        $urlslug = 'api/oauth/token';
        $reuqestData = array(
            "grant_type" => "client_credentials",
            "client_id" => $_ENV('shopware_client_id'),
            "client_secret" => $_ENV('shopware_client_secret')
        );


        $apiURL = $_ENV('shopware_url').$urlslug;
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$this->getAuthToken()
        ];

        $request = new Request('POST', $apiURL, $headers, $reuqestData);
        $auth_result = json_decode($request->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        return $auth_result['access_token'];
    }


    /**
     * @throws JsonException
     */
    public function postData($urlslug, $body) {

        $apiURL = $_ENV('shopware_url').$urlslug;
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$this->getAuthToken()
        ];

        $request = new Request('POST', $apiURL, $headers, $body);

        return json_decode($request->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }





}