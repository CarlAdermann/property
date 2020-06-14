<?php

use Illuminate\Database\Seeder;
use App\Models\AnalyticType;


class AnalyticTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnalyticType::create([
            'name' => "max_Bld_Height_m",
            'units' => 'm',
            'is_numeric' => 1,
            'num_decimal_places' => 1,
        ]);

        AnalyticType::create([
            'name' => "min_lot_size_m2",
            'units' => 'm2',
            'is_numeric' => 1,
            'num_decimal_places' => 0,
        ]);

        AnalyticType::create([
            'name' => "fsr",
            'units' => ':1',
            'is_numeric' => 1,
            'num_decimal_places' => 2,
        ]);
    }
}
