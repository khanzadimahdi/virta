<?php

namespace App\DTOs;

class Station
{
    private string $name;
    private float $latitude;
    private float $longitude;
    private int $companyId;
    private string $address;

    public function __construct(
        string $name,
        float $latitude,
        float $longitude,
        int $companyId,
        string $address
    )
    {
        $this->name = $name;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->companyId = $companyId;
        $this->address = $address;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getCompanyId(): int
    {
        return $this->companyId;
    }

    public function getAddress(): string
    {
        return $this->address;
    }
}
