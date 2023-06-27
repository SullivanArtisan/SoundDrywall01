<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Customer;

class CustomerSeeder extends Seeder
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
                Customer::create([
                        'cstm_account_no' => $faker->numberBetween($min = 1001, $max = 4000),
                        'cstm_account_name' => $faker->company(),
                        'cstm_address' => $faker->address(),
                        'cstm_city' => $faker->city(),
                        'cstm_province' => $faker->state(),
                        'cstm_postcode' => $faker->postcode(),
                ]);
        }
    }
}
