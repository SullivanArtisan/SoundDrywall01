<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Terminal;

class TerminalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach(range(1, 50) as $index)
        {
                $vin = $faker->md5();
                Terminal::create([
                        'trmnl_name' => $faker->firstName(),
                        'trmnl_address' => $faker->streetAddress(),
                        'trmnl_city' => $faker->city(),
						'trmnl_province' => $faker->stateAbbr(),
						'trmnl_country' => $faker->randomElement($array = array ('','Canada','USA','Mexico')),
						'trmnl_area' => $faker->randomElement($array = array ('','COMOX','ABCLA','BCBUI','DELTAPORT','EUROASIAQB')),
                ]);
        }
    }
}
