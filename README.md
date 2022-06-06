# localbitcoins-client

A Localbitcoins Client for PHP with minimal dependencies. Should work
right off the box.

Documentation for the Localbitcoins API can be found here: <https://localbitcoins.com/api-docs/>.

## Installing

Make sure you have cURL enabled in your php environment.

```console
php --ri curl
```

you should see this text on your terminal:

`
cURL support => enabled
`

Install with composer

```console
composer require bradtech/localbitcoins-client
```

## Usage

To use the HMAC Authentication Client, create a new`HMACAuthenticationClient` object and
initialize with the HMAC key and secret from Localbitcoins.

```php
<?php

// you can load the files dynamically
require_once 'vendor/autoload.php';

use Bradtech\LocalbitcoinsClient\HMACAuthenticationClient;

$hmac_key = 'HMAC_KEY';
$hmac_secret = 'HMAC_SECRET';

$client = new HMACAuthenticationClient($hmac_key, $hmac_secret);

$data = $client->getWalletAddress();

var_dump($data);
```
