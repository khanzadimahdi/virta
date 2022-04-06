<?php

namespace App\Services;

use App\DTOs\Company as CompanyDTO;
use App\Models\Company as CompanyModel;
use App\Repositories\Company as CompanyRepository;

class CompanyService
{
    private CompanyRepository $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function paginatedList($perPage = 15)
    {
        $paginatedCompanies = $this->companyRepository->all($perPage);

        return $paginatedCompanies;
    }

    public function create(CompanyDTO $dto): CompanyModel
    {
        $attributes = [
            'name' => $dto->getName(),
            'parent_company_id' => $dto->getParentCompanyId()
        ];

        return $this->companyRepository->create($attributes);
    }

    public function update(CompanyModel $company, CompanyDTO $dto): bool
    {
        $attributes = [
            'name' => $dto->getName(),
            'parent_company_id' => $dto->getParentCompanyId()
        ];

        return $this->companyRepository->update($company, $attributes);
    }

    public function delete(CompanyModel $company): bool
    {
        return $this->companyRepository->delete($company);
    }
}
