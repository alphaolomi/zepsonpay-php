<div align="center"><img src="./docs/logo.png"> <h1>ZepsonPay for PHP</h1></div>

Zepson pay is the software as a service payment gateway designed to make payment integration through API's easily and available to anyone. Zepson Engineers works on real world researches to get solution suitable for your business.

## Features

- Collection (also available Android pay)
- Disbursements
- Transaction Enquiry (also available Android pay)
- Transaction reversal
- Fraud Check

## Documentation

Read the detailed [Developer Documentation](https://zepsonpay.com/public/docs)

## How to integrate to PHP/ Laravel Application

1. Install ZepsonPay Package
2. Prepare your API key, API secret and environment from `zepsonpay.com` developer dashboard
3. Create an Instance of ZepsonPay Class
4. Pass Required Parameters
5. Call `makePayment` to initiate makePayment
6. Call `paymentStatus` to get transaction status

## Installation

Install using composer in php or Laravel application

```bash
composer require zepson/zepsonpay-php
```

## Usage

Create an instance of ZepsonPay class using bellow instruction. > Note that parameters in the example are all mandatory when initializing the class. `api_key` and `api_secret` can be obtained from [developer portal](https://zepsonpay.com)

```php
$api_key = "YOUR_ZEPSONPAY_API_KEY";
$api_secret = "YOUR_ZEPSONPAY_API_SECRET";

// 'sandbox', 'production', 'zepsonpay' and 'android'.
// Currently support android (v1.0)
$environment = "android";

// Create instance of Zepsonpay class.
$zp = new Zepson\ZepsonpaySDK\ZepsonPay(
    $api_key,
    $api_secret,
    $environment
);
```

## Make payment

To complete payment, the parameters in the example are required. `Make payment` can also be refereed to `Collection transaction`.

```php

$data = [
    'amount' => 100,
    'purpose' => 'For testing purposes',

    // For Android transaction
    // This is equal to operators transaction id received after payment
    'ext_trxn_reff' => '1JF61RJWOK',

    // Customer phone
    'phone' => '0688950846',

    // Operator to charge from
    'operator' => 'vodacom',

    // Only for Android transactions
    // obtained after registering device in `gateway.zepsonsms.co.tz`
    'device' => '00000000-0000-0000-6da8-08a4x40d4b97'
];

// Make payment
$response = $zp->makePayment($data);

print_r($response)
```

After making payment, please refer to call back sections below to see how can you work with different
responses from the api.

## Transaction enquiry (Check transaction status)

To check status, the parameter in the example is required. Transaction status is sometimes
refereed to as transaction enquiry

```php

$data = [
    // For android transactions
    // this is equal to operators transaction id received after payment
    'ext_trxn_reff' => '1JF61RJWOK',
];

// Make payment
$response = $zp->paymentStatus($data);
```

After receiving response, please refer to call back sections below to see how can you work with different
responses from the API.

<br>

## Available Payment response helpers

We have prepared a list of helpers to help make your process much easy, you can use this for any type of transaction /environment.

### Check if payment is successful

```php
$zp->isPaymentSuccess();
```

**Zepsonpay status codes**

| CODE        | DESCRIPTION                                                              |
| :---------- | :----------------------------------------------------------------------- |
| `ZPSUCCESS` | Payment has successfully completed                                       |
| `ZPPENDING` | Payment is being processed                                               |
| `ZPFAILED`  | Payment request failed                                                   |
| `ZPEXISTED` | Payment reference code existed, send transaction enquiry/status to check |
| `ZPFRAUD`   | Payment is marked as fraud due to failure to pass fraud matrix           |

### Get full transaction response as array

Example

```php
$zp->getFullResponseArray();
```

### Get full transaction response as Json

Example

```php
$zp->getFullResponseJson();
```

### Get transaction ID

Example

```php
$zp->getTransactionId();
```

### Get external transaction ID

Example

```php
$zp->getExternalTransactionId();
```

### Get Response message

```php
$zp->getMessage();
```

### Get response transaction message

```php
$zp->getTransactionMessage();
```

### Get errors

```php
$zp->getErrors();
```

# Android Transaction

This is quite simple and does not require much documents, your integration approval is done automatically.

Here you will need an account at `gateway.zepsonsms.co.tz` , go to `device section` and register your phone (Android).

Create your Zepsonpay account and create your app, On the Business category select Android, you'll get your `app id` and `app key`, use them to integrate with the API.

Your required to add device id (from Zepson SMS gateway) and your webhook secret by going to your `gateway.zepsonsms.co.tz` account, tools and select webhook, the create webhook, add url https://zepsonpay.com/webhook , you will get your webhook secret key, use it to integrate with our API.

## Road map

- MNOs Collection
- MNOs Disbursement
- ZepsonPay aggregation (Still in progress)
- VPN tunnelling (Work in progress)

## Contributing

Contributions are always welcome to help make the package more user friendly!

## Authors

- [@pro-cms](https://www.github.com/pro-cms)
- [@pbijampola](https://www.github.com/pbijampola)
- [@alphaolomi](https://www.github.com/alphaolomi)
- [@Zepson-Tech](https://www.github.com/Zepson-Tech)

## License

This project is licensed under [MIT License](https://choosealicense.com/licenses/mit/) 
