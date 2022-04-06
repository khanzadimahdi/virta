<?php

namespace App\Repositories;

use App\Models\Station as StationModel;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class Station
{
    protected StationModel $stationModel;

    public function __construct(StationModel $stationModel)
    {
        $this->stationModel = $stationModel;
    }

    public function all($perPage = 15): Paginator
    {
        return $this->stationModel->orderBy('id', 'desc')->paginate($perPage);
    }

    public function create(array $attributes): StationModel
    {
        return $this->stationModel->create($attributes);
    }

    public function update(StationModel $company, $attributes): bool
    {
        return $company->update($attributes);
    }

    public function delete(StationModel $company): bool
    {
        return $company->delete();
    }

    public function nearestStations(float $latitude, float $longitude, $distance = 2, ?int $companyId = null): Collection
    {
        return $this
            ->stationModel
            ->nearest($latitude, $longitude, $distance)
            ->when(
                !empty($companyId), function (Builder $query) use ($companyId) {
                    $query->where('company_id', $companyId);
                }
            )
            ->get();
    }
}
