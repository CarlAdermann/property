<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Str;


class PropertyControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic create property test.
     *
     * @return void
     */
    public function testCreateTest()
    {
        $data = [
            'country' => 'example country',
            'state' => 'example state',
            'suburb' => 'example suburb',
            'guid' => \Str::uuid(),
        ];

        $response = $this->json('POST','/api/property', $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('properties', $data);
    }

    /**
     * @dataProvider createValidationProvider
     */
    public function testCreatePropertyValidationTest($status, $data)
    {
        $response = $this->json('POST','/api/property', $data);

        $response->assertStatus($status);

        $this->assertDatabaseMissing('properties', $data);
    }

    public function createValidationProvider()
    {
        $missingGuid = [
            'country' => 'example country',
            'state' => 'example state',
            'suburb' => 'example suburb',
        ];

        $missingSuburb = [
            'country' => 'example country',
            'state' => 'example state',
            'guid' => '2436e291-d72a-47b7-9de1-9bd8de41d2d4',
        ];

        $missingCountry = [
            'state' => 'example state',
            'suburb' => 'example suburb',
            'guid' => '2436e291-d72a-47b7-9de1-9bd8de41d2d4',
        ];

        $missingState = [
            'country' => 'example country',
            'suburb' => 'example suburb',
            'guid' => '2436e291-d72a-47b7-9de1-9bd8de41d2d4',
        ];

        return [
            [422, $missingGuid],
            [422, $missingState],
            [422, $missingCountry],
            [422, $missingSuburb],
        ];
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreatePropertyGuidReturns422OnDuplicateGuidTest()
    {
        $data = [
            'country' => 'example country',
            'state' => 'example state',
            'suburb' => 'example suburb',
            'guid' => \Str::uuid(),
        ];

        $response = $this->json('POST','/api/property', $data);

        $response->assertStatus(201);

        $response = $this->json('POST','/api/property', $data);

        $response->assertJson(['errors' => [
            'guid' =>  [
                'The guid has already been taken.'
            ]
        ]]);


        $this->assertDatabaseHas('properties', $data);
    }
}
