<?php

namespace Tests\Unit\DTOs;

use App\DTOs\Company;
use PHPUnit\Framework\TestCase;

class CompanyTest extends TestCase
{
    public function test_getters()
    {
        $attributes = [
            'name' => 'test station',
            'parentCompanyId' => random_int(-90, 90),
        ];

        $dto = new Company(
            $attributes['name'],
            $attributes['parentCompanyId'],
        );

        foreach ($attributes as $key => $expectedValue) {
            $actualValue = $dto->{'get' . ucwords($key)}();

            $this->assertEquals($expectedValue, $actualValue);
        }
    }
}
