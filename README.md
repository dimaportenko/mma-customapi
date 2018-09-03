### About
Magento 2 add custom rest api endpoints

##### Cagegory tree with image attribute 
{base_url}/rest/default/mma/categories

##### Get Braintree client token
{base_url}/rest/default/mma/braintree/token

##### Get Vault for client
{base_url}/rest/default/mma/me/vault/items

##### Get nonce for braintree vault 
{base_url}/rest/default/mma/me/vault/nonce

### Install
composer require mma/customapi<br>
php bin/magento setup:upgrade<br>
php bin/magento cache:clean

### Compatibility
Tested on Magento Commerce 2.2.5
