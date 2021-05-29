<?php

namespace App\Http\Interfaces;

Interface PaymentGatewayInterface {

   public function PaymentGateway($datos);
   public function getAuthentication($login, $secretKey);
   public function getPayment($reference, $description, $currency, $total);
   public function TransActionInfo($requestId);

}