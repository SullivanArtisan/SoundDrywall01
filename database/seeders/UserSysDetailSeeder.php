<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\UserSysDetail;
use Illuminate\Support\Facades\DB;

class UserSysDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        // following line retrieve all the user_ids from DB
        $userIds = DB::table('users')->pluck('id');
        foreach($userIds as $userId){
			if ($userId > 36) {
				$userDetail = UserSysDetail::create([
					'user_id' => $userId,
					'current_office' => $faker->randomElement($array = array ('HL','TW','OT')),
					'default_office' => $faker->randomElement($array = array ('HL','TW','OT')),
					'ops_code' => $faker->randomElement($array = array ('Highway','Admin','Local')),
				]);
			}
        }
    }
}
?>
