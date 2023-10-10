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
        ExpressAdapter::class,
        BoxberryAdapter::class,
        DHLAdpater::class,
    ];

    protected array $packageCalculations = [];

    protected array $resultCalculations = [];


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
                $this->packageCalculations[] = $this->resultDto;
                $this->resultDto = [];
            }
        }catch (\Throwable $e) {
            Log::debug($e->getMessage());
        }

        $this->prepareCalculationsToReturn();

        return $this->resultCalculations;
    }

    protected function prepareCalculationsToReturn(): void
    {
        try {
            foreach ($this->packageCalculations as $packageResult) {

                /**
                 * @var $resultDto ResultDto
                 */
                $resultDto = $packageResult[0];
                $packageArray = $this->makePackageArray($resultDto);

                foreach ($packageResult as $resultDto) {
                    $fastDeliveryArray = $this->makeFastDeliveryArray
                    ($resultDto);

                    $packageArray['companies'][$resultDto
                        ->getTransportCompanyName()]['fastDelivery'] =
                        $fastDeliveryArray;

                    $slowDeliveryArray = $this->makeSlowDeliveryArray($resultDto);
                    $packageArray['companies'][$resultDto
                        ->getTransportCompanyName()]['slowDelivery'] =
                        $slowDeliveryArray;
                }

                $this->resultCalculations[] = $packageArray;
            }

        } catch(\Throwable $e) {
            Log::debug($e->getMessage());
        }

    }

    protected function makeFastDeliveryArray(ResultDto $resultDto): array
    {
        $fastDeliveryDto = $resultDto->getFastDeliveryDto();

        $slowDeliveryArray['price'] = $fastDeliveryDto->getPrice();
        $slowDeliveryArray['date'] = $fastDeliveryDto->getDate();
        $slowDeliveryArray['error'] = $fastDeliveryDto->getError();

        return $slowDeliveryArray;
    }

    protected function makeSlowDeliveryArray(ResultDto $resultDto): array
    {
        $slowDeliveryDto = $resultDto->getSlowDeliveryDto();

        $slowDeliveryArray['price'] = $slowDeliveryDto->getPrice();
        $slowDeliveryArray['date'] = $slowDeliveryDto->getDate();
        $slowDeliveryArray['error'] = $slowDeliveryDto->getError();

        return $slowDeliveryArray;
    }

    protected function makePackageArray(ResultDto $resultDto): array
    {
        $packageArray['sourceKladr'] = $resultDto->getPackageDto()
            ->getSourceKladr();
        $packageArray['targetKladr'] = $resultDto->getPackageDto()
            ->getTargetKladr();
        $packageArray['weight'] = $resultDto->getPackageDto()
            ->getWeight();

        $packageArray['companies'] = [];
        return $packageArray;
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
