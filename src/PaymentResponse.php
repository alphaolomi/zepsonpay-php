<?php

namespace Zepson\ZepsonpaySDK;



class PaymentResponse
{

    /** 
     * Response Body in JSON String
     * @var array
     */
    public $response;

    /** 
     * Response Body as PHP Array
     * @var string
     */
    public $response_json;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        $this->response_json = $response;
        $this->response = json_decode($response, true);
    }

    /**
     * @return bool
     */
    public function isPaymentSuccess()
    {
        if ($this->response['success'] == true) {
            return $this->response['code'];
        } else {
            return $this->response['code'];
        }
    }

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->response['data']['transaction_id'];
    }

    /**
     * @return string
     */
    public function getExternalTransactionId()
    {
        return $this->response['data']['ext_trxn_reff'];
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->response['message'];
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->response['errors'];
    }

    /**
     * @return string
     */
    public function getTransactionMessage()
    {
        return $this->response['data']['message'];
    }

    /**
     * @return array
     */
    public function getFullResponseArray()
    {
        return $this->response;
    }

    /**
     * @return string
     */
    public function getFullResponseJson()
    {
        return $this->response_json;
    }
}
