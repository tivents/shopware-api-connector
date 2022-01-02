<?php

namespace ShopwareApiConnector;

class OrdersController
{

    public function listOrders($filter = null) : array
    {

        if($filter == null) {
            $filter = [
                [
                    "type" => "equals",
                    "field" => "order.stateMachineState.technicalName",
                    "value" => "open"
                ],
                [
                    "type" => "equals",
                    "field" => "transactions.stateMachineState.technicalName",
                    "value" => "paid"
                ],[
                    "type" => "equals",
                    "field" => "deliveries.stateMachineState.technicalName",
                    "value" => "open"
                ]
            ];
        }

        $requestBody = [
            "filter" => $filter,
            "associations"=> [
                "orderCustomer"=> [
                    "associations"=> [
                        "customer"=> [],
                        "salutation"=> []
                    ]
                ],
                "transactions" => [
                    "associations"=> [
                        "paymentMethod"=> []
                    ]
                ],
                "deliveries" => [],
                "addresses"=> [
                    "associations"=> [
                        "country"=> []
                    ]
                ],
                "lineItems" => [
                    "associations" => [
                        "product"=> []
                    ]
                ]
            ],
            "includes" => [
                "order_customer"=> ["customerId", "customerNumber","email", "salutationId", "title", "firstName", "lastName", "createdAt", "updatedAt"],
                "country"=> ["name", "iso", "iso3"]
            ]
        ];

        return $this->apicontroller->postData('shopware', 'api/search/order', $requestBody, $this->getAuthToken());
    }
}