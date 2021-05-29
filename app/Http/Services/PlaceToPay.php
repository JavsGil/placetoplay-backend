<?php

namespace App\Http\Services;

use App\Http\Interfaces\PaymentGatewayInterface;
use Illuminate\Support\Facades\Http;

class PlaceToPay implements PaymentGatewayInterface
{
    public function PaymentGateway($datos):Object
    {
        $time = strtotime('+20 minutes');
        $expire_time = date('c', $time);
        $login = '6dd490faf9cb87a9862245da41170ff2';
        $secretKey = '024h1IlD';

        $payload = new \stdClass;
        $payload->auth = $this->getAuthentication($login, $secretKey);
        $payload->payment = $this->getPayment($datos['reference'], $datos['description'], $datos['currency'], $datos['total'] );

        $payload->locale = "en_CO";
        $payload->expiration = $expire_time;
        $payload->returnUrl = "https://webhook.site/95d37eef-61cd-47a2-97fd-c88650ce2b0d";
        $payload->ipAddress = "127.0.0.1";
        $payload->userAgent = "PlacetoPay Sandbox";

        $response = Http::withHeaders([
            'Content-type' => 'application/json'
        ])->acceptJson()->post(
            'https://test.placetopay.com/redirection/api/session/',
            json_decode(json_encode($payload), true)
        );

        $res = json_decode($response->body());
        return response()->json($res);
    }

    public function getAuthentication($login, $secretKey):Object
    {
        $seed = date('c');
        if (function_exists('random_bytes')) {
            $nonce = bin2hex(random_bytes(16));
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $nonce = bin2hex(openssl_random_pseudo_bytes(16));
        } else {
            $nonce = mt_rand();
        }

        $nonceBase64 = base64_encode($nonce);
        $tranKey = base64_encode(sha1($nonce . $seed . $secretKey, true));

        $auth = new \stdClass;
        $auth->login = $login;
        $auth->tranKey = $tranKey;
        $auth->nonce = $nonceBase64;
        $auth->seed = $seed;

        return $auth;
    }
    
    public function getPayment($reference, $description, $currency, $total):Object
    {
        $amount = new \stdClass;
        $amount->currency = $currency;
        $amount->total = $total;

        $payment = new \stdClass;
        $payment->reference = $reference;
        $payment->description = $description;
        $payment->amount = $amount;

        return $payment;
    }

    public function TransActionInfo($requestId):Object
    {
        $login = '6dd490faf9cb87a9862245da41170ff2';
        $secretKey = '024h1IlD';

        $payload = new \stdClass;
        $payload->auth = $this->getAuthentication($login, $secretKey);
      
        $response = Http::withHeaders([
            'Content-type' => 'application/json'
        ])->acceptJson()->post(
            "https://test.placetopay.com/redirection/api/session/$requestId",
            json_decode(json_encode($payload), true)
        );    
        $res = json_decode($response->body());
        return response()->json($res);

    }
    
}
