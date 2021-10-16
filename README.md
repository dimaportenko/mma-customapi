
<div>
  <a align="center" href="https://github.com/dimaportenko?tab=followers">
    <img src="https://img.shields.io/github/followers/dimaportenko?label=Follow%20%40dimaportenko&style=social" />
  </a>
  <br/>
  <a align="center" href="https://twitter.com/dimaportenko">
    <img src="https://img.shields.io/twitter/follow/dimaportenko?label=Follow%20%40dimaportenko&style=social" />
  </a>
  <br/>
  <a align="center" href="https://www.youtube.com/channel/UCReKeeIMZywvQoaZPZKzQbQ">
    <img src="https://img.shields.io/youtube/channel/subscribers/UCReKeeIMZywvQoaZPZKzQbQ" />
  </a>
  <br/>
  <a align="center" href="https://www.youtube.com/channel/UCReKeeIMZywvQoaZPZKzQbQ">
    <img src="https://img.shields.io/youtube/channel/views/UCReKeeIMZywvQoaZPZKzQbQ" />
  </a>
</div>

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

##### Get paypal security token for quote
{base_url}/rest/default/V1/mma/paypal/transparent/securityToken/:quote_id

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

##### Get product reviews
{base_url}/rest/default/V1/mma/review/reviews/:productId

##### Get product ratings
{base_url}/rest/default/V1/mma/rating/ratings/:store_id

##### Post product review from authorized customer
{base_url}/rest/default/V1/mma/review/mine/post

##### Post product review from guest customer
{base_url}/rest/default/V1/mma/review/guest/post

##### Post contact form
{base_url}/rest/default/V1/mma/contact/post


### Install
composer require mma/customapi<br>
php bin/magento setup:upgrade<br>
php bin/magento cache:clean

### Compatibility
Tested on Magento Commerce 2.2.5

### Learning    
Check my videos about Magento 2 Rest API development basics https://www.youtube.com/playlist?list=PL97fL9DAn9Qy5kCQfPVrfh9pGNYeG0vmS
