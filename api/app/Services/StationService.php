<?php

namespace App\Services;

use App\DTOs\Station as StationDTO;
use App\Models\Station as StationModel;
use App\Repositories\Station as StationRepository;
use Illuminate\Support\Collection;

class StationService
{
    private StationRepository $stationRepository;

    public function __construct(StationRepository $stationRepository)
    {
        $this->stationRepository = $stationRepository;
    }

    public function paginatedList($perPage = 15)
    {
        $paginatedCompanies = $this->stationRepository->all($perPage);

        return $paginatedCompanies;
    }

    public function create(StationDTO $dto): StationModel
    {
        $attributes = [
            'name' => $dto->getName(),
            'latitude' => $dto->getLatitude(),
            'longitude' => $dto->getLongitude(),
            'company_id' => $dto->getCompanyId(),
            'address' => $dto->getAddress(),
        ];

        return $this->stationRepository->create($attributes);
    }

    public function update(StationModel $station, StationDTO $dto): bool
    {
        $attributes = [
            'name' => $dto->getName(),
            'latitude' => $dto->getLatitude(),
            'longitude' => $dto->getLongitude(),
            'company_id' => $dto->getCompanyId(),
            'address' => $dto->getAddress(),
        ];

        return $this->stationRepository->update($station, $attributes);
    }

    public function delete(StationModel $station): bool
    {
        return $this->stationRepository->delete($station);
    }

    public function nearestStations(float $latitude, float $longitude, float $distance = 2, ?int $companyId = null): Collection
    {
        $stations = $this->stationRepository->nearestStations($latitude, $longitude, $distance, $companyId);
        $stations->transform(function(StationModel $station) {
            $station->children = $station->childStations();

            return $station;
        });

        return $stations;
    }
}
