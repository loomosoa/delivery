<?php

namespace App\Services\Delivery;

use App\Services\Delivery\Abstracts\BaseDeliveryAdapter;
use App\Services\Delivery\Interfaces\TransportCompanyInterface;
use Illuminate\Support\Facades\Log;

class DeliveryService
{

    protected array $data;

    protected array $packagesDto = [];

    protected array $resultDto = [];

    protected array $transportCompanies = [
        SDEKAdapter::class,
//        ExpressAdapter::class,
//        BoxberryAdapter::class,
//        DHLAdpater::class,
    ];


    public function calculate(): array
    {
        foreach ($this->data as $item) {
            $packageDto = new PackageDto();
            $packageDto->setSourceKladr($item['sourceKladr']);
            $packageDto->setTargetKladr($item['targetKladr']);
            $packageDto->setWeight($item['weight']);
            $packageDto->setPickedTransportCompanyId($item['pickedTransportCompanyId']);

            $this->packagesDto[] = $packageDto;
        }

        try {
            foreach ($this->packagesDto as $packageDto) {
                foreach ($this->transportCompanies as $companyClass) {
                    $resultDto = new ResultDto();
                    $resultDto->setPackageDto($packageDto);

                    /**
                     * @var TransportCompanyInterface $company
                     */
                    $company = new $companyClass();
                    $company->calculate($resultDto);
                    $this->resultDto[] = $resultDto;
                }
            }
        }catch (\Throwable $e) {
            Log::debug($e->getMessage());
        }


        $some = 1;
        /*
         * v приходят посылки,
         * для каждой необходимо определить стоимость и время доставки
         * всеми транспортными компаниями
         *
         * в рамках быстрой и медленной доставки
         *
         * значит ответ
         *
         * package
         * company
         *     isPicked: true/false
         *     fastDelivery {
         *          price
         *          period
         *          error
         *     }
         *
         *     slowDelivery {
         *          price
         *          coefficient
         *          period
         *          error
         *     }
         *
         * для расчета мы передаем packageDto и делаем запрос в API
         * транспортной компании
         *
         * на выходе получаем данные, и из них формируем FastDeliveryDto
         * и slowDeliveryDto
         * */



        return [];
    }



    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }
}
