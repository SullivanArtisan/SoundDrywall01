<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker; 
use App\Models\Company;

class CompanySeeder extends Seeder
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
                Company::create([
                        'cmpny_name' => $faker->unique()->company(),
                        'cmpny_address' => $faker->streetAddress(),
                        'cmpny_city' => $faker->city(),
                        'cmpny_province' => $faker->state(),
                        'cmpny_postcode' => $faker->postcode(),
                        'cmpny_country' => $faker->country(),
                        'cmpny_contact' => $faker->name($gender = null),
                        'cmpny_tel' => $faker->phoneNumber(),
                        'cmpny_email' => $faker->email(),
                ]);
        }
    }
}
