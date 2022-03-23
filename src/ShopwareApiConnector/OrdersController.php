<?php

namespace ShopwareApiConnector;


use Vin\ShopwareSdk\Client\AdminAuthenticator;
use Vin\ShopwareSdk\Client\GrantType\ClientCredentialsGrantType;
use Vin\ShopwareSdk\Client\GrantType\PasswordGrantType;
use Vin\ShopwareSdk\Data\Context;
use Vin\ShopwareSdk\Data\Criteria;
use Vin\ShopwareSdk\Data\Entity\Order\OrderDefinition;
use Vin\ShopwareSdk\Data\Filter\EqualsFilter;
use Vin\ShopwareSdk\Factory\RepositoryFactory;

class OrdersController extends ConnectorController
{

    /**
     * @var BaseController
     */
    private $baseController;
    private mixed $shopUrl;
    private ClientCredentialsGrantType|PasswordGrantType $grantType;

    public function __construct()
    {
        parent::__construct();
        $this->baseController = new BaseController();
        $this->grantType = $this->baseController->getGrantType();
        $this->shopUrl = $_ENV['SHOPWARE_URL'];
    }


    public function listOrders($filter = null) : \Vin\ShopwareSdk\Repository\Struct\EntitySearchResult
    {

        $orderRepository = RepositoryFactory::create(OrderDefinition::ENTITY_NAME);


        $adminClient = new AdminAuthenticator($this->getGrantType(), $this->shopUrl);
        $accessToken = $adminClient->fetchAccessToken();
        $context = new Context($this->shopUrl, $accessToken);

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('shippingFree', true));



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

        return $orderRepository->search($criteria, $context);;
    }

    function updateOrder($id) {
        $orderRepository = RepositoryFactory::update(OrderDefinition::ENTITY_NAME);
    }
}
