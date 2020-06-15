<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Property;
use App\Models\AnalyticType;
use App\Models\PropertyAnalytic;


class PropertyAnalyticControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Create Property Analytic Test.
     *
     * @return void
     */
    public function testCreatePropertyAnalyticTest()
    {
        $property = factory(Property::class)->create();
        $analyticType = factory(AnalyticType::class)->create();

        $data = [
            'analytic_type_id' => $analyticType->id,
            'value' => 1.2,
        ];

        $response = $this->json('POST','/api/property/' . $property->id . '/analytics', $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('property_analytics', $data);
    }

    /**
     * Update Property Analytic Test.
     *
     * @return void
     */
    public function testUpdatePropertyAnalyticTest()
    {
        $property = factory(Property::class)->create();
        $analyticType = factory(AnalyticType::class)->create();
        $propertyAnalytic = factory(PropertyAnalytic::class)->create([
            'property_id' => $property->id,
            'analytic_type_id' => $analyticType->id,
        ]);

        $response = $this->json('PUT','/api/analytics/' . $propertyAnalytic->id, ['value' => '10']);

        $response->assertStatus(200);

        $this->assertDatabaseHas('property_analytics', [
            'property_id' => $property->id,
            'analytic_type_id' => $analyticType->id,
            'value' => 10,
        ]);
    }

    /**
     * Update Property Analytic Test.
     *
     * @return void
     */
    public function testDeletePropertyAnalyticTest()
    {
        $property = factory(Property::class)->create();
        $analyticType = factory(AnalyticType::class)->create();
        $propertyAnalytic = factory(PropertyAnalytic::class)->create([
            'property_id' => $property->id,
            'analytic_type_id' => $analyticType->id,
        ]);

        $response = $this->json('DELETE','/api/analytics/' . $propertyAnalytic->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('property_analytics', [
            'id' => $propertyAnalytic->id,
        ]);
    }

    /**
     * Show Property Analytic Test.
     *
     * @return void
     */
    public function testShowPropertyAnalyticTest()
    {
        $property = factory(Property::class)->create();
        $analyticType = factory(AnalyticType::class)->create();
        $propertyAnalytic = factory(PropertyAnalytic::class)->create([
            'property_id' => $property->id,
            'analytic_type_id' => $analyticType->id,
        ]);

        $response = $this->json('GET','/api/property/' . $property->id . '/analytics');

        $response->assertStatus(200);

        $response->assertJson([
            $propertyAnalytic->toArray()
        ]);
    }
}
