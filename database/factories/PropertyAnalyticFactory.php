<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\PropertyAnalytic;
use Faker\Generator as Faker;

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

$factory->define(PropertyAnalytic::class, function (Faker $faker) {
    return [
        'property_id' => 1,
        'analytic_type_id' => 1,
        'value' => 1,
    ];
});
