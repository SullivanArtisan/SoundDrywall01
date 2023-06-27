<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        // $users = User::lists('id');
        foreach(range(1, 50) as $index)
        {
            User::create([
				'name' => $faker->name(),
				'email' => $faker->unique()->safeEmail(),
				'email_verified_at' => now(),
				'password' => '$2y$10$lqaNutIhCPKVHGaB1jfXqunrmqFFr/UUz0XjDS8FS3OAaalzftTgm', // password
				// 'remember_token' => Str::random(10),
				'docket_prefix' => $faker->randomElement($array = array ('AB','CD','EF','GH','IJ','KL','MN')),
				'next_docket_number' => $faker->numberBetween($min = 100, $max = 999),
				'security_level' => $faker->randomElement($array = array ('Full Security','Admin','Operations Supervisor','Dispatch-Coordinator','Gatehouse','Chassis','Accounting','Satety','TIDEWATER-USERS')),
				'address' => $faker->streetAddress(),
				'town' => $faker->city(),
				'county' => $faker->stateAbbr(),
				'postcode' => $faker->postcode(),
				'home_phone' => $faker->tollFreePhoneNumber(),
				'mobile_phone' => $faker->tollFreePhoneNumber(),
            ]);
        }
    }
}
?>
