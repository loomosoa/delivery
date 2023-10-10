<?php

namespace App\Services\Delivery;

use App\Services\Delivery\Abstracts\BaseDeliveryAdapter;
use App\Services\Delivery\Interfaces\DeliveryInterface;

class DeliveryService extends BaseDeliveryAdapter implements DeliveryInterface
{

    protected array $data;

    protected array $transportCompanies = [
        SDEKAdapter::class,
        ExpressAdapter::class,
        BoxberryAdapter::class,
        DHLAdpater::class,
    ];


    public function calculateFastDelivery()
    {
        // TODO: Implement calculateFastDelivery() method.
    }

    public function calculateSlowDelivery()
    {
        // TODO: Implement calculateSlowDelivery() method.
    }

    public function calculate(): array
    {
        $some = 1;
        /*
         * приходят посылки,
         * для каждой необходимо определить стоимость доставки
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
