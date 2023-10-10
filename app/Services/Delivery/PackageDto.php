<?php
declare(strict_types=1);

namespace App\Services\Delivery;

class PackageDto
{
    protected string $sourceKladr;

    protected string $targetKladr;

    protected float $weight;

    protected int|null $pickedTransportCompanyId = null;

    /**
     * @return string
     */
    public function getSourceKladr(): string
    {
        return $this->sourceKladr;
    }

    /**
     * @param string $sourceKladr
     */
    public function setSourceKladr(string $sourceKladr): void
    {
        $this->sourceKladr = $sourceKladr;
    }

    /**
     * @return string
     */
    public function getTargetKladr(): string
    {
        return $this->targetKladr;
    }

    /**
     * @param string $targetKladr
     */
    public function setTargetKladr(string $targetKladr): void
    {
        $this->targetKladr = $targetKladr;
    }

    /**
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     */
    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return int|null
     */
    public function getPickedTransportCompanyId(): ?int
    {
        return $this->pickedTransportCompanyId;
    }

    /**
     * @param int|null $pickedTransportCompanyId
     */
    public function setPickedTransportCompanyId(?int $pickedTransportCompanyId): void
    {
        $this->pickedTransportCompanyId = $pickedTransportCompanyId;
    }



}
