# bol.com Open API PHP client #
API client for the bol.com Open API

**The library contains the following requests:**
- Ping request
- Product request
- Recommendation request
- RelatedProducts request
- Offer request
- Lists request
- Search request
- Sessions request
- Basket requests
- Wishlist requests
- setReferrer request (You need to ask extended permission from Developer Center team for this request)
- Auth requests through bol.com Bearer token (You need to ask extended permission from Developer Center team for this request)
- Legacy Auth requests (You need to ask extended permission from Developer Center team for this request)

## Install using Composer ##

Please include the following vcs config to your `composer.json`
```json
"repositories": [
    {
        "type": "vcs",
        "url":  "https://github.com/Storewire/bolcom-openapi-php-client.git"
    }
]
```
After that, run the following command
```bash
composer require "storewire/bol-openapi-php-client" "dev-main"
```
## Minimum requirements: ##
- PHP 8.0 (or higher)
- JSON PHP extension

## Developer Documentation ##
https://affiliate.bol.com/nl/api-documentatie

## Basic example ##

```php
require 'vendor/autoload.php'

$apiClient = new BolCom\Client('YOUR_BEARER_TOKEN');
$response = $apiClient->getProduct('1002004010708531');
var_dump($response);
```

## Running tests ##

```bash
BOLCOM_OPEN_API_KEY=YOUR_LEGACY_OPEN_API_KEY composer test
```
