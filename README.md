# localbitcoins-client

A Localbitcoins Client for PHP with minimal dependencies. Should work
right off the box.

Documentation for the Localbitcoins API can be found here: <https://localbitcoins.com/api-docs/>.

## Installing

Make sure you have cURL enabled in your php environment.

```sh
php --ri curl
```

you should see this text:

```text
cURL support => enabled
```

Install with composer

```console
composer require bradtech/localbitcoins-client
```

## Usage

To use the HMAC Authentication Client, create a new`HMACAuthenticationClient` object and
initialize with the HMAC key and secret from Localbitcoins.

```php
<?php
use Bradtech\LocalbitcoinsClient\HMACAuthenticationClient;

define(HMAC_KEY, "<localbitcoins_hmac_key>");
define(HMAC_SECRET, "<localbitcoins_hmac_secret>");

$client = new HMACAuthenticationClient(HMAC_KEY, HMAC_SECRET);

// get the wallet address
$client->getWalletAddr();

// etc...

```
