<?php

namespace Tests\Feature;

use App\Models\AnalyticType;
use App\Models\Property;
use App\Models\PropertyAnalytic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Str;


class SummaryControllerTest extends TestCase
{
//    use DatabaseTransactions;
    use RefreshDatabase;

    protected $property;
    protected $analyticType;

    public function setUp(): void
    {
        parent::setUp();

        $this->property = factory(Property::class)->create();
        $this->analyticType = factory(AnalyticType::class)->create();
    }

    public function testCreateTest()
    {
        $this->createPropertyAnalytic(1);

        $response = $this->json('GET','/api/summary');

        $response->assertStatus(200);

        $response->assertJson([
            'min' => 1,
            'max' => 1,
            'median' => 1,
            'with_value_percent' => 100,
            'without_value_percent' => 0,
        ]);
    }

    public function testMinMaxMedian()
    {
        $this->createPropertyAnalytic(1);
        $this->createPropertyAnalytic(2);

        $response = $this->json('GET','/api/summary');

        $response->assertStatus(200);

        $response->assertJson([
            'min' => 1,
            'max' => 2,
            'median' => 1.5,
            'with_value_percent' => 100,
            'without_value_percent' => 0,
        ]);
    }

    public function testWithValuePercentAndWithoutValuePercent()
    {
        // Create a second property without a value
        // There exists in the database for this test one property with a value
        // and one without
        factory(Property::class)->create();

        $this->createPropertyAnalytic(1);
        $this->createPropertyAnalytic(2);

        $response = $this->json('GET','/api/summary');

        $response->assertStatus(200);

        $response->assertJson([
            'min' => 1,
            'max' => 2,
            'median' => 1.5,
            'with_value_percent' => 50,
            'without_value_percent' => 50,
        ]);
    }

    public function testNoResultsResponse()
    {
        factory(Property::class)->create([
            'country' => 'Australia'
        ]);

        $response = $this->json('GET','/api/summary');

        $response->assertJson([
            'min' => null,
            'max' => null,
            'median' => null,
            'with_value_percent' => 0,
            'without_value_percent' => 100,
        ]);
    }

    public function testCountryFilter()
    {
        $this->createPropertyAnalytic(1); // This analytic is persisted in the database but filtered out of the results

        $this->property = factory(Property::class)->create([
            'country' => 'Australia'
            ]);

        $this->analyticType = factory(AnalyticType::class)->create();

        $this->createPropertyAnalytic(10);

        $response = $this->json('GET','/api/summary?country=Australia');

        $response->assertJson([
            'min' => 10,
            'max' => 10,
            'median' => 10,
            'with_value_percent' => 100,
            'without_value_percent' => 0,
        ]);
    }

    public function testStateFilter()
    {
        $this->createPropertyAnalytic(1); // This analytic is persisted in the database but filtered out of the results

        $this->property = factory(Property::class)->create([
            'state' => 'nsw'
        ]);

        $this->analyticType = factory(AnalyticType::class)->create();

        $this->createPropertyAnalytic(10);

        $response = $this->json('GET','/api/summary?state=nsw');

        $response->assertJson([
            'min' => 10,
            'max' => 10,
            'median' => 10,
            'with_value_percent' => 100,
            'without_value_percent' => 0,
        ]);
    }

    public function testSuburbFilter()
    {
        $this->createPropertyAnalytic(1); // This analytic is persisted in the database but filtered out of the results

        $this->property = factory(Property::class)->create([
            'suburb' => 'sydney'
        ]);

        $this->analyticType = factory(AnalyticType::class)->create();

        $this->createPropertyAnalytic(10);

        $response = $this->json('GET','/api/summary?suburb=sydney');

        $response->assertJson([
            'min' => 10,
            'max' => 10,
            'median' => 10,
            'with_value_percent' => 100,
            'without_value_percent' => 0,
        ]);
    }

    private function createPropertyAnalytic($value)
    {
        return factory(PropertyAnalytic::class)->create([
            'property_id' => $this->property->id,
            'analytic_type_id' => $this->analyticType->id,
            'value' => $value,
        ]);
    }
}
