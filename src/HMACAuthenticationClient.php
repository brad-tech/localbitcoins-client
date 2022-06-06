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

    const BASE_URL = "https://localbitcoins.com";

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
     * @return mixed
     */
    public function getWalletAddress(): mixed
    {
        $apiEndpoint = '/api/wallet-addr';
        // start: nonce
        //
        // this is a bit insecure but will ensure a constant increase in nonce 
        // value according to the documentation:
        //
        // A nonce is an integer number, that needs to increase with every API 
        // request. It's value has to always be greater than the previous request
        $nonce = time();
        // end: nonce

        $params = "";

        $signature = $this->_generateSignature($nonce, $apiEndpoint, $params);

        return $this->_sendRequest($nonce, $apiEndpoint, $signature);
    }

    /**
     * Send a generic request to the api endpoint.
     * 
     * @param $nonce       The nonce value
     * @param $apiEndpoint The target endpoint
     * @param $signature   The generated signature
     * @param $method      HTTP Method to execute
     * 
     * @return mixed
     */
    private function _sendRequest($nonce, $apiEndpoint, $signature, $method = 'GET')
    {
        $headers = array(
            "Apiauth-Key: $this->_hmac_key",
            "Apiauth-Nonce: $nonce",
            "Apiauth-Signature: $signature",
            "Content-Type: application/x-www-form-urlencoded",
            "cache-control: no-cache"
        );

        $curl = curl_init();

        $options = array(
            CURLOPT_URL => self::BASE_URL . $apiEndpoint,
            CURLOPT_CUSTOMREQUEST, $method,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSH_COMPRESSION => true,
        );

        curl_setopt_array($curl, $options);

        $response = curl_exec($curl);
        curl_close($curl);

        $data = unserialize($response);

        return $data;
    }

    /**
     * Generate a random uppercase HMAC signature.
     * 
     * @param $nonce       The required nonce value to generate the signature
     * @param $apiEndpoint The API endpoint, for example, /api/wallet/.
     * @param $params      URLEncoded API arguments
     * 
     * @return string
     */
    private function _generateSignature(
        int $nonce,
        string $apiEndpoint,
        string $params
    ): string {
        $signature = '';

        $signature = hash_hmac(
            'sha256',
            $nonce . $this->_hmac_key . $apiEndpoint. $params,
            $this->_hmac_secret
        );

        return strtoupper($signature);
    }
}
