<?php
declare(strict_types=1);

namespace App\Services\Delivery\Abstracts;

use App\Services\Delivery\ApiResponseDto;
use App\Services\Delivery\FastDeliveryDto;
use App\Services\Delivery\ResultDto;
use App\Services\Delivery\SlowDeliveryDto;
use Illuminate\Support\Carbon;

abstract class BaseDeliveryAdapter
{
    protected int $transportCompanyId;

    protected int $basicPriceForSlowDelivery = 150;

    protected string $transportCompanyName = "";

    const DELIVERY_APPLICATION_ACCEPTANCE_CLOSE_HOUR = 18;

    public function calculate(ResultDto $resultDto)
    {
        $fastDeliveryDto = $this->calculateFastDelivery($resultDto->getPackageDto());
        $slowDeliveryDto = $this->calculateSlowDelivery($resultDto->getPackageDto());

        $resultDto->setFastDeliveryDto($fastDeliveryDto);
        $resultDto->setSlowDeliveryDto($slowDeliveryDto);

        if ($this->transportCompanyId === $resultDto->getPackageDto()
                ->getPickedTransportCompanyId()) {
            $resultDto->setIsCompanyPicked(true);
        }
        $resultDto->setTransportCompanyName($this->transportCompanyName);
    }

    protected function initFastDeliveryDto(FastDeliveryDto $fastDeliveryDto,
                                           ApiResponseDto $apiResponseDto)
    {
        $fastDeliveryDto->setPrice($apiResponseDto->getPrice());
        $fastDeliveryDto->setPeriod($apiResponseDto->getDeliveryPeriod());
        $fastDeliveryDto->setDate($apiResponseDto->getDeliveryDate());
        $fastDeliveryDto->setError($apiResponseDto->getError());
    }

    protected function initSlowDeliveryDto(SlowDeliveryDto $slowDeliveryDto,
                                           ApiResponseDto $apiResponseDto)
    {
        $slowDeliveryDto->setPrice($apiResponseDto->getPrice());
        $slowDeliveryDto->setPeriod($apiResponseDto->getDeliveryPeriod());
        $slowDeliveryDto->setDate($apiResponseDto->getDeliveryDate());
        $slowDeliveryDto->setError($apiResponseDto->getError());
    }

    protected function initFakeApiFastDeliveryResponseDto (ApiResponseDto
                                                  $apiResponseDto)
    {
        $apiResponseDto->setError("");
        $apiResponseDto->setPrice((float)mt_rand(400,1500));

        $additionalDay = 0;
        $currentHour = (int)date("H");
        if ($currentHour >= self::DELIVERY_APPLICATION_ACCEPTANCE_CLOSE_HOUR) {
            $additionalDay = 1;
        }

        $apiResponseDto->setDeliveryPeriod(mt_rand(1,3) + $additionalDay);
        $apiResponseDto->setDeliveryDate(Carbon::now()
            ->addDays($apiResponseDto->getDeliveryPeriod())
            ->format("Y-m-d"));
    }

    protected function initFakeApiSlowDeliveryResponseDto(ApiResponseDto
                                                  $apiResponseDto)
    {
        $apiResponseDto->setError("");
        $apiResponseDto->setDeliveryPeriod(mt_rand(4,9));
        $apiResponseDto->setDeliveryDate(Carbon::now()
            ->addDays($apiResponseDto->getDeliveryPeriod())
            ->format("Y-m-d"));

        $apiResponseDto->setPrice($apiResponseDto->getCoefficient() *
            $this->basicPriceForSlowDelivery);
    }
}
