<?php

namespace Tests\Unit\DTOs;

use App\DTOs\Station;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Str;

class StationTest extends TestCase
{
    public function test_getters()
    {
        $attributes = [
            'name' => Str::random(),
            'latitude' => random_int(-90, 90),
            'longitude' => random_int(-180, 180),
            'companyId' => random_int(0, 1000),
            'address' => Str::random(),
        ];

        $dto = new Station(
            $attributes['name'],
            $attributes['latitude'],
            $attributes['longitude'],
            $attributes['companyId'],
            $attributes['address'],
        );

        foreach ($attributes as $key => $expectedValue) {
            $actualValue = $dto->{'get' . ucwords($key)}();

            $this->assertEquals($expectedValue, $actualValue);
        }
    }
}
