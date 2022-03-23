<?php

namespace App\Models;

use Database\Factories\StationFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

class Station extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'latitude', 'longitude',
        'company_id', 'address',
    ];

    protected static function newFactory()
    {
        return new StationFactory;
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function childStations(): Collection
    {
        $children = collect([]);

        $this->loadMissing('company.children.stations.company');
        if ($this->company->children->isNotEmpty()) {
            $children = $children->merge($this->company->children->pluck('stations')->flatten()->all());
            foreach ($children as $child) {
                $children = $children->merge($child->childStations());
            }
        }

        $this->company->unsetRelation('children');

        return $children;
    }

    public function scopeNearest(Builder $query, float $latitude, float $longitude, float $radius = 2)
    {
        // 6371 for kilometer and 3956 for miles
        $calculateDistance =
            'format(
                (
                    6371
                    * acos(
                        cos(radians(?))
                        * cos(radians(latitude))
                        * cos(radians(longitude) - radians(?))
                        + sin(radians(?))
                        * sin(radians(latitude))
                    )
                ), 6
            )
            AS distance';

        $fields = sprintf('*, %s', $calculateDistance);

        $query
            ->selectRaw($fields, [$latitude, $longitude, $latitude])
            ->having("distance", "<", $radius);

        return $query;
    }
}
