<?php

namespace ShopwareApiConnector;

class ProductsController extends ConnectorController
{

    public function listProducts($filter = null) : array
    {
        if($filter == null) {
            $filter = [];
        }

        $requestBody = [
            "filter" => $filter,
        ];

        return $this->postData('api/search/product', $requestBody);
    }

    public function createProduct()
    {

        return $products;
    }

    public function getProduct()
    {

        return $products;
    }

    public function updateProduct()
    {
        return $products;
    }

    public function deleteProduct()
    {
        return $status;
    }
}