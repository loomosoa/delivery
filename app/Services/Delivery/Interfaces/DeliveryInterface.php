<?php

namespace App\Services\Delivery\Interfaces;

interface DeliveryInterface
{

    public function calculateFastDelivery();
    public function calculateSlowDelivery();

}
