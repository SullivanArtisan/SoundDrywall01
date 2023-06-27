<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Driver;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach(range(1, 20) as $index)
        {
                $vin = $faker->md5();
                Driver::create([
                    'dvr_pwr_unit_no_1' => $faker->bothify('?###?'),
                    'dvr_no' => $faker->unique()->bothify('?????####'),
                    'dvr_name' => $faker->name(),
                    'dvr_email' => $faker->unique()->email(),
                    'dvr_start_date' => $faker->date(),
                    'dvr_type' => $faker->randomElement($array = array ('Owner-Operator','Company','Subhauler')),
                    'dvr_license_no' => $faker->unique()->numberBetween($min = 1111111, $max = 9999999),
                    'dvr_sin' => $faker->unique()->numberBetween($min = 111111111, $max = 999999999),
                ]);
        }
    }
}
