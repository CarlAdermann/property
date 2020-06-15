<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Property;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Property::class, function (Faker $faker) {
    return [
        'country' => 'example country',
        'state' => 'example state',
        'suburb' => 'example suburb',
        'guid' => \Str::uuid(),
    ];
});
