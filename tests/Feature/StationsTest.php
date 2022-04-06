<?php

namespace Tests\Feature;

use App\Models\Station;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StationsTest  extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_station_search()
    {
        $station = Station::factory()->create();
        $response = $this->get(route('api.v1.stations.search', [
            'latitude' => $station->latitude,
            'longitude' => $station->longitude,
        ]));

        $response->assertStatus(200);
        $response->assertJsonPath('data.0.id', $station->id);
        $response->assertJsonPath('data.0.children', []);
    }

    public function test_station_search_if_children_exist()
    {
        $parentStation = Station::factory()->create();
        $childStation = Station::factory()->create();

        $childStation->company->forceFill(['parent_company_id' => $parentStation->company->id])->save();

        $response = $this->get(route('api.v1.stations.search', [
            'latitude' => $parentStation->latitude,
            'longitude' => $parentStation->longitude,
        ]));

        $response->assertStatus(200);
        $response->assertJsonPath('data.0.id', $parentStation->id);
        $response->assertJsonPath('data.0.children.0.id', $childStation->id);
    }

    public function test_station_list()
    {
        $response = $this->get(route('api.v1.stations.index'));
        $response->assertStatus(200);
    }

    public function test_store_station()
    {
        $company = Company::factory()->create();

        $attributes = [
            'name' => $this->faker()->text(),
            'latitude' => $this->faker()->latitude(),
            'longitude' => $this->faker()->longitude(),
            'company_id' => $company->id,
            'address' => $this->faker()->address(),
        ];

        $response = $this->post(route('api.v1.stations.store'), $attributes);
        $response->assertCreated();
    }

    public function test_update_station()
    {
        $company = Company::factory()->create();

        $station = Station::factory()->create();

        $attributes = [
            'name' => $this->faker()->text(),
            'latitude' => $this->faker()->latitude(),
            'longitude' => $this->faker()->longitude(),
            'company_id' => $company->id,
            'address' => $this->faker()->address(),
        ];

        $response = $this->patch(route('api.v1.stations.update', $station), $attributes);
        $response->assertStatus(200);

        $station->refresh();
        $this->assertEquals($attributes['name'], $station->name);
        $this->assertEquals($attributes['latitude'], $station->latitude);
        $this->assertEquals($attributes['longitude'], $station->longitude);
        $this->assertEquals($attributes['company_id'], $station->company_id);
        $this->assertEquals($attributes['address'], $station->address);
    }

    public function test_destroy_station()
    {
        $station = Station::factory()->create();

        $response = $this->delete(route('api.v1.stations.destroy', $station));
        $response->assertStatus(200);

        $this->assertDeleted($station);
    }
}
