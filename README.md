# localbitcoins-client

A Localbitcoins Client for PHP

## Installing

Install with composer

```console
composer require bradtech/localbitcoins-client
```

## Usage

To use the HMAC Authentication Client, create a new
`HMACAuthenticationClient` object and initialize with
the hmac key and secret from Localbitcoins.

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
