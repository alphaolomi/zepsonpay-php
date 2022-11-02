<?php

namespace Zepson\ZepsonpaySDK;

class ZepsonPay
{
    const BASE_URL = "http://41.59.112.185/api/v1/";

    /**
     * Sample
     * ```php
     *    $zp = new ZepsonPay(
     *        "api_key" => "YOUR_API_KEY",
     *        "api_secret" => "YOUR_API_SECRET",
     *        "environment" => "sandbox",// For Android, use `android`
     *    );
     * ```
     */
    public function __construct($api_key = null, $api_secret = null, $environment = null)
    {
        $this->api_key = $api_key;
        $this->api_secret = $api_secret;
        $this->environment = $environment;
    }

    /**
     * @param array $data
     * @return PaymentResponse
     */
    public function makePayment($data)
    {
        // Validate data
        foreach (['amount', 'purpose', 'ext_trxn_reff', 'phone', 'operator', 'device'] as $value) {
            if (!array_key_exists($value, $data)) {
                return [
                    'success' => false,
                    'message' =>  "Required parameters are missing: {$value}"
                ];
            }
        }
        if ($this->environment == "android" && !isset($data['device']) || empty($data['device'])) {
            return [
                'success' => false,
                'message' => 'device_id is required for android transaction'

            ];
        }

        $url = self::BASE_URL . "collection";
        $data = [
            'api_key' => $this->api_key,
            'api_secret' => $this->api_secret,
            'environment' => $this->environment,
        ];
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_RETURNTRANSFER => true,
        ]);

        $server_output = curl_exec($ch);
        curl_close($ch);


        return new PaymentResponse($server_output);
    }

    /**
     * @param array $data
     * @return PaymentResponse
     */
    public function paymentStatus($data)
    {
        if (!array_key_exists('ext_trxn_reff', $data) || !empty($data['ext_trxn_reff'])) {
            return [
                'success' => false,
                'message' => 'External Transaction Reference is required'
            ];
        }

        $base_url = self::BASE_URL . "collection/status";
        $data = [
            'api_key' => $this->api_key,
            'api_secret' => $this->api_secret,
            'environment' => $this->environment,
            'ext_trxn_reff' => $data['ext_trxn_reff']
        ];

        $data = http_build_query($data);
        $full_url = sprintf("%s?%s", $base_url, $data);

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL =>  $full_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);
        $response = curl_exec($curl);

        curl_close($curl);

        return new PaymentResponse($response);
    }
}
