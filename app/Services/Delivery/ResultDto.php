<?php
declare(strict_types=1);

namespace App\Services\Delivery;
class ResultDto
{
    protected PackageDto $packageDto;

    protected int $transportCompanyId;

    protected FastDeliveryDto $fastDeliveryDto;

    protected SlowDeliveryDto $slowDeliveryDto;

    protected bool $isCompanyPicked = false;

    protected string $transportCompanyName = "";

    /**
     * @return string
     */
    public function getTransportCompanyName(): string
    {
        return $this->transportCompanyName;
    }

    /**
     * @param string $transportCompanyName
     */
    public function setTransportCompanyName(string $transportCompanyName): void
    {
        $this->transportCompanyName = $transportCompanyName;
    }

    /**
     * @return PackageDto
     */
    public function getPackageDto(): PackageDto
    {
        return $this->packageDto;
    }

    /**
     * @param PackageDto $packageDto
     */
    public function setPackageDto(PackageDto $packageDto): void
    {
        $this->packageDto = $packageDto;
    }

    /**
     * @return int
     */
    public function getTransportCompanyId(): int
    {
        return $this->transportCompanyId;
    }

    /**
     * @param int $transportCompanyId
     */
    public function setTransportCompanyId(int $transportCompanyId): void
    {
        $this->transportCompanyId = $transportCompanyId;
    }

    /**
     * @return FastDeliveryDto
     */
    public function getFastDeliveryDto(): FastDeliveryDto
    {
        return $this->fastDeliveryDto;
    }

    /**
     * @param FastDeliveryDto $fastDeliveryDto
     */
    public function setFastDeliveryDto(FastDeliveryDto $fastDeliveryDto): void
    {
        $this->fastDeliveryDto = $fastDeliveryDto;
    }

    /**
     * @return SlowDeliveryDto
     */
    public function getSlowDeliveryDto(): SlowDeliveryDto
    {
        return $this->slowDeliveryDto;
    }

    /**
     * @param SlowDeliveryDto $slowDeliveryDto
     */
    public function setSlowDeliveryDto(SlowDeliveryDto $slowDeliveryDto): void
    {
        $this->slowDeliveryDto = $slowDeliveryDto;
    }

    /**
     * @return bool
     */
    public function isCompanyPicked(): bool
    {
        return $this->isCompanyPicked;
    }

    /**
     * @param bool $isCompanyPicked
     */
    public function setIsCompanyPicked(bool $isCompanyPicked): void
    {
        $this->isCompanyPicked = $isCompanyPicked;
    }

}
