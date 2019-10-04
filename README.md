### About
Magento 2 add custom rest api endpoints

##### Cagegory tree with image attribute 
{base_url}/rest/default/V1/mma/categories

##### Get Braintree client token
{base_url}/rest/default/V1/mma/braintree/token

##### Get Vault for client
{base_url}/rest/default/V1/mma/me/vault/items

##### Get nonce for braintree vault 
{base_url}/rest/default/V1/mma/me/vault/nonce

##### Get Magento version 
{base_url}/rest/default/V1/mma/magento/version

##### Get Magento most viewed products 
{base_url}/rest/default/V1/mma/products/most-viewed/:limit

##### Get Magento best seller products 
{base_url}/rest/default/V1/mma/products/best-seller/:limit

##### Get Magento top rated products 
{base_url}/rest/default/V1/mma/products/top-rated/:limit

##### Get Magento new products 
{base_url}/rest/default/V1/mma/products/new/:limit

### Install
composer require mma/customapi<br>
php bin/magento setup:upgrade<br>
php bin/magento cache:clean

### Compatibility
Tested on Magento Commerce 2.2.5
