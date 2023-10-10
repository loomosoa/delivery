<?php
declare(strict_types=1);

namespace App\Services\Delivery;

use App\Services\Delivery\Abstracts\BaseDeliveryAdapter;
use App\Services\Delivery\Interfaces\TransportCompanyInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class BoxberryAdapter extends BaseDeliveryAdapter implements TransportCompanyInterface
{
    protected int $transportCompanyId = 3;

    protected string $transportCompanyName = "Boxberry";

    public function calculateFastDelivery(PackageDto $dto): FastDeliveryDto
    {
        try {
            $fastDeliveryDto = new FastDeliveryDto();
            $apiResponse = new ApiResponseDto();

            // request Boxberry API with $dto->getSourceKladr(),
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

            // request Boxberry API with $dto->getSourceKladr(),
            // $dto->getTargetKladr(), $dto->getWeight()

            $apiResponse->setCoefficient(1.7);
            $this->initFakeApiSlowDeliveryResponseDto($apiResponse);
            $this->initSlowDeliveryDto($slowDeliveryDto, $apiResponse);

        }catch (\Throwable $e) {
            Log::error($e->getMessage());
            $slowDeliveryDto->setError($apiResponse->getError());
        }

        return $slowDeliveryDto;
    }
}
