<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\AnalyticType;
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

$factory->define(AnalyticType::class, function (Faker $faker) {
    return [
        'name' => 'name',
        'units' => 'm',
        'is_numeric' => 1,
        'num_decimal_places' => 3,
    ];
});
