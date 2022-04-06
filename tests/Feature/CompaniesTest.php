<?php

namespace Tests\Feature;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompaniesTest  extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_company_list()
    {
        $response = $this->get(route('api.v1.companies.index'));
        $response->assertStatus(200);
    }

    public function test_store_company()
    {
        $company = Company::factory()->create();

        $attributes = [
            'name' => $this->faker()->text(),
            'parent_company_id' => $company->id,
        ];

        $response = $this->post(route('api.v1.companies.store'), $attributes);
        $response->assertCreated();
    }

    public function test_update_company()
    {
        $parentCompany = Company::factory()->create();

        $company = Company::factory()->create();

        $attributes = [
            'name' => $this->faker()->text(),
            'parent_company_id' => $parentCompany->id,
        ];

        $response = $this->patch(route('api.v1.companies.update', $company), $attributes);
        $response->assertStatus(200);

        $company->refresh();
        $this->assertEquals($attributes['name'], $company->name);
        $this->assertEquals($attributes['parent_company_id'], $company->parent_company_id);
    }

    public function test_destroy_company()
    {
        $company = Company::factory()->create();

        $response = $this->delete(route('api.v1.companies.destroy', $company));
        $response->assertStatus(200);

        $this->assertDeleted($company);
    }
}
