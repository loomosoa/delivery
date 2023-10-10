<?php
namespace App\Services\Delivery;

class PackageDto
{
    protected string $sourceKladr;

    protected string $targetKladr;

    protected float $weight;

    protected int|null $pickedTransportCompanyId = null;



}
