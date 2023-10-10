<?php

namespace App\Services\Delivery\Interfaces;

use App\Services\Delivery\FastDeliveryDto;
use App\Services\Delivery\PackageDto;
use App\Services\Delivery\ResultDto;
use App\Services\Delivery\SlowDeliveryDto;

interface TransportCompanyInterface
{

    public function calculateFastDelivery(PackageDto $dto): FastDeliveryDto;
    public function calculateSlowDelivery(PackageDto $dto): SlowDeliveryDto;

    public function calculate(ResultDto $dto);

}
