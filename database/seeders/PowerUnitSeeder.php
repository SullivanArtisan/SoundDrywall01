<?php

namespace Database\Seeders;
use Faker\Factory as Faker;
use App\Models\PowerUnit;

use Illuminate\Database\Seeder;

class PowerUnitSeeder extends Seeder
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
			PowerUnit::create([
				'unit_id' => 'H'.$faker->numberBetween($min = 100, $max = 999),
				'year' => $faker->numberBetween($min = 1998, $max = 2021),
				'make' => $faker->randomElement($array = array ('Volvo','Toyota','Mercedes','Peterbuilt','Kenworth','Hino','RollsRoyce')),
				'plate_number' => $faker->bothify('??####'),
				'vin' => substr($vin, 0, strlen($vin)-1),
			]);
		}
    }
}
