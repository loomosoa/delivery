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
            $packageDto = $this->makePackageDto($item);
            $this->packagesDto[] = $packageDto;
        }

        try {
            foreach ($this->packagesDto as $packageDto) {
                $results = [];
                foreach ($this->transportCompanies as $companyClass) {
                    $resultDto = new ResultDto();
                    $resultDto->setPackageDto($packageDto);

                    /**
                     * @var TransportCompanyInterface $company
                     */
                    $company = new $companyClass();
                    $company->calculate($resultDto);
                    $results[] = $resultDto;
                }
                $this->packageCalculations[] = $results;
            }
        }catch (\Throwable $e) {
            Log::debug($e->getMessage());
        }

        $this->prepareCalculationsToReturn();

        return $this->resultCalculations;
    }

    protected function makePackageDto(array $item): PackageDto
    {
        $packageDto = new PackageDto();
        $packageDto->setSourceKladr($item['sourceKladr']);
        $packageDto->setTargetKladr($item['targetKladr']);
        $packageDto->setWeight($item['weight']);
        $packageDto->setPickedTransportCompanyId($item['pickedTransportCompanyId']);
        return $packageDto;
    }

    protected function prepareCalculationsToReturn(): void
    {
        try {
            foreach ($this->packageCalculations as $results) {

                /**
                 * @var $resultDto ResultDto
                 */
                $resultDto = $results[0];
                $packageArray = $this->makePackageArray($resultDto);

                foreach ($results as $resultDto) {
                    $packageArray = $this->makePackageArrayForCompanies
                    ($packageArray, $resultDto);
                }

                $this->resultCalculations[] = $packageArray;
            }

        } catch(\Throwable $e) {
            Log::debug($e->getMessage());
        }

    }

    protected function makePackageArrayForCompanies(array $packageArray,
                                                    ResultDto $resultDto): array
    {
        $fastDeliveryArray = $this->makeFastDeliveryArray
        ($resultDto);

        $packageArray['companies'][$resultDto
            ->getTransportCompanyName()]['fastDelivery'] =
            $fastDeliveryArray;

        $slowDeliveryArray = $this->makeSlowDeliveryArray($resultDto);
        $packageArray['companies'][$resultDto
            ->getTransportCompanyName()]['slowDelivery'] =
            $slowDeliveryArray;

        $packageArray['companies'][$resultDto->getTransportCompanyName()]['isCompanyPicked']
            = $resultDto->isCompanyPicked();

        return $packageArray;
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
