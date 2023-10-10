<?php

namespace App\Services\Delivery;

use App\Services\Delivery\Abstracts\BaseDeliveryAdapter;
use App\Services\Delivery\Interfaces\TransportCompanyInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;

class SDEKAdapter extends BaseDeliveryAdapter implements TransportCompanyInterface
{

    protected int $transportCompanyId = 1;

    public function calculateFastDelivery(PackageDto $dto): FastDeliveryDto
    {
        $kladrFrom = $dto->getSourceKladr();
        $kladrTo = $dto->getTargetKladr();
        $weight = $dto->getWeight();


        // request SDEK API with $kladrFrom, $kladrTo, $weight

        try {
            $apiResponse = new \StdClass();
            $apiResponse->error = "";

            $fastDeliveryDto = new FastDeliveryDto();

            if ($apiResponse->error === "") {
                $apiResponse->price = mt_rand(400,999);
                $apiResponse->deliveryPeriod = mt_rand(1,9);
                $apiResponse->deliveryDate = Carbon::now()
                    ->addDays($apiResponse->deliveryPeriod)
                    ->format("Y-m-d");

                $fastDeliveryDto->setPrice((float)$apiResponse->price);
                $fastDeliveryDto->setPeriod($apiResponse->deliveryPeriod);
                $fastDeliveryDto->setDate($apiResponse->deliveryDate);
            } else {
                $fastDeliveryDto->setError($apiResponse->error);
            }

        }catch (\Throwable $e) {
            Log::error($e->getMessage());
        }

        return $fastDeliveryDto;
    }

    public function calculateSlowDelivery(PackageDto $dto): SlowDeliveryDto
    {
        // TODO: Implement calculateSlowDelivery() method.
    }

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
    }
}
