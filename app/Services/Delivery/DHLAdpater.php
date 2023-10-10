<?php

namespace App\Services\Delivery;

use App\Services\Delivery\Abstracts\BaseDeliveryAdapter;
use App\Services\Delivery\Interfaces\TransportCompanyInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class DHLAdpater extends BaseDeliveryAdapter implements TransportCompanyInterface
{
    protected int $transportCompanyId = 4;

    protected string $transportCompanyName = "DHL";

    public function calculateFastDelivery(PackageDto $dto): FastDeliveryDto
    {
        try {
            $fastDeliveryDto = new FastDeliveryDto();
            $apiResponse = new ApiResponseDto();

            // request DHL API with $dto->getSourceKladr(),
            // $dto->getTargetKladr(), $dto->getWeight()

            $this->initFakeApiFastDeliveryResponseDto($apiResponse);
            $this->initFastDeliveryDto($fastDeliveryDto, $apiResponse);

        }catch (\Throwable $e) {
            Log::error($e->getMessage());
            $fastDeliveryDto->setError($apiResponse->getError());
        }

        return $fastDeliveryDto;
    }

    public function calculateSlowDelivery(PackageDto $dto): SlowDeliveryDto
    {
        try {
            $slowDeliveryDto = new SlowDeliveryDto();
            $apiResponse = new ApiResponseDto();

            // request DHL API with $dto->getSourceKladr(),
            // $dto->getTargetKladr(), $dto->getWeight()

            $apiResponse->setCoefficient(3.6);
            $this->initFakeApiSlowDeliveryResponseDto($apiResponse);
            $this->initSlowDeliveryDto($slowDeliveryDto, $apiResponse);

        }catch (\Throwable $e) {
            Log::error($e->getMessage());
            $slowDeliveryDto->setError($apiResponse->getError());
        }

        return $slowDeliveryDto;
    }
}
