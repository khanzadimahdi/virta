<?php

namespace App\Repositories;

use App\Models\Company as CompanyModel;
use Illuminate\Contracts\Pagination\Paginator;

class Company
{
    protected CompanyModel $companyModel;

    public function __construct(CompanyModel $companyModel)
    {
        $this->companyModel = $companyModel;
    }

    public function all($perPage = 15): Paginator
    {
        return $this->companyModel->orderBy('id', 'desc')->paginate($perPage);
    }

    public function create(array $attributes): CompanyModel
    {
        return $this->companyModel->create($attributes);
    }

    public function update(CompanyModel $company, $attributes): bool
    {
        return $company->update($attributes);
    }

    public function delete(CompanyModel $company): bool
    {
        return $company->delete();
    }
}
