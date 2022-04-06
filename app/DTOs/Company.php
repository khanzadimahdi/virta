<?php

namespace App\DTOs;

class Company
{
    private string $name;
    private ?int $parentCompanyId;

    public function __construct(string $name, ?int $parentCompanyId = null)
    {
        $this->name = $name;
        $this->parentCompanyId = $parentCompanyId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParentCompanyId(): ?int
    {
        return $this->parentCompanyId;
    }
}
