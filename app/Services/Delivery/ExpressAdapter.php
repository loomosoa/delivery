<?php

namespace App\Services\Delivery;

use App\Services\Delivery\Abstracts\BaseDeliveryAdapter;
use App\Services\Delivery\Interfaces\TransportCompanyInterface;

class ExpressAdapter extends BaseDeliveryAdapter implements TransportCompanyInterface
{

    protected int $transportCompanyId = 2;

    public function calculateFastDelivery(PackageDto $dto)
    {
        // TODO: Implement calculateFastDelivery() method.
    }

    public function calculateSlowDelivery(PackageDto $dto)
    {
        // TODO: Implement calculateSlowDelivery() method.
    }

    public function calculate(ResultDto $dto)
    {
        // TODO: Implement calculate() method.
    }
}
