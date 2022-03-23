# TIVENTS Shopware API connector


## Install
````
composer require tivents/shopware-api-connector
````

## Usage

**THIS PACKAGE IS UNDER HIGH DEVELOPMENT! DON'T USE IT IN PRODUCTION**

Set your shopUrl, clientId and your clientSecret in a .env file like:

````
SHOPWARE_AUTH_METHOD='https://shop.test/'
SHOPWARE_AUTH_METHOD=client_crediantials
SHOPWARE_URL='https://shop.test/'
SHOPWARE_CLIENT_ID='SWCLIENTSHOPID'
SHOPWARE_CLIENT_SECRET='ShopWareSuper100Percent0ZeroRisKSecret'
````

## Roadmap/To-Do
* Products
* * [ ] product search
* * [ ] create product
* * [ ] single product show
* * [ ] update product
* * [ ] delete product
* Customers
* * [ ] customer search
* * [ ] create customer
* * [ ] single customer show
* * [ ] update customer
* * [ ] delete customer
* Orders
* * [x] order search
* * [ ] single order show
* * [ ] update order
* * [ ] delete order
