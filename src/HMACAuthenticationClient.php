<?php

/**
 * HMACAuthenticationClient.php
 * 
 * Contains the HMACAuthenticationClient class
 * 
 * PHP Version ^8.0
 * 
 * @category File
 * @package  Bradtech\LocalbitcoinsClient
 * @author   Adams Korir <adekorir@gmail.com>
 * @license  MIT https://mit-license.org/
 * @link     https://gihub.com/brad-tech/localbitcoins-client.git
 */

namespace Bradtech\LocalbitcoinsClient;

/**
 * Http Client for connecting to Localbitcoins
 * 
 * @category Class
 * @package  BradTech\Localbitcoins
 * @author   Adams Korir <adekorir@gmail.com>
 * @license  MIT https://mit-license.org/
 * @link     https://gihub.com/brad-tech/localbitcoins-client.git
 */
class HMACAuthenticationClient
{

    const BASE_URL = "https://localbitcoins.com/api";

    private $_hmac_key;
    private $_hmac_secret;

    /**
     * Create a new instance of the client.
     * 
     * @param $hmacKey    HMAC Key required to authenticate requests
     * @param $hmacSecret HMAC Secret required to authenticate requests
     */
    public function __construct(string $hmacKey, string $hmacSecret)
    {
        $this->_hmac_key = $hmacKey;
        $this->_hmac_secret = $hmacSecret;
    }

    /**
     * Get Wallet Address
     * 
     * Returns an unused receiving address from the token owner's wallet. 
     * The address is returned in the address key of the response. Note that this
     * may keep returning the same (unused) address if requested repeatedly.
     * 
     * @return array
     */
    public function getWalletAddr(): array
    {
        $requestUri = self::BASE_URL . '/wallet-addr';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $requestUri);
        curl_setopt($ch, CURLOPT_SSH_COMPRESSION, true);
        curl_setopt_array(
            $ch,
            [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_URL => $requestUri
            ]
        );

        $result = curl_exec($ch);
        $data = unserialize($result);

        return $data;

        // $nonce = rand(0, 10000);
        // $sig = hash_hmac(
        //     'sha256',
        //     $this->_hmac_key . $this->_hmac_secret . $nonce,
        //     ""
        // );
    }
}
