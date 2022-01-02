<?php

namespace ShopwareApiConnector;

class ConnectorController extends BaseController
{
    function getAuthToken() {
        $urlslug = 'api/oauth/token';
        $reuqestData = array(
            "grant_type" => "client_credentials",
            "client_id" => $this->f3->get('shopware_client_id'),
            "client_secret" => $this->f3->get('shopware_client_secret')
        );
        $auth_result = $this->apicontroller->postData('shopware', $urlslug, $reuqestData);

        return $auth_result['access_token'];
    }


}