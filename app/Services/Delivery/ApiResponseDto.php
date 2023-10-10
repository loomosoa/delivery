<?php
namespace App\Services\Delivery;
class ApiResponseDto
{
    protected float $price;

    protected int $deliveryPeriod;

    protected string $deliveryDate;

    protected string $error;

    protected float $coefficient;

    /**
     * @return float
     */
    public function getCoefficient(): float
    {
        return $this->coefficient;
    }

    /**
     * @param float $coefficient
     */
    public function setCoefficient(float $coefficient): void
    {
        $this->coefficient = $coefficient;
    }


    /**
     * @return string
     */
    public function getDeliveryDate(): string
    {
        return $this->deliveryDate;
    }

    /**
     * @param string $deliveryDate
     */
    public function setDeliveryDate(string $deliveryDate): void
    {
        $this->deliveryDate = $deliveryDate;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @param string $error
     */
    public function setError(string $error): void
    {
        $this->error = $error;
    }

    /**
     * @return int
     */
    public function getDeliveryPeriod(): int
    {
        return $this->deliveryPeriod;
    }

    /**
     * @param int $deliveryPeriod
     */
    public function setDeliveryPeriod(int $deliveryPeriod): void
    {
        $this->deliveryPeriod = $deliveryPeriod;
    }

}
