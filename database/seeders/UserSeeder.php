<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

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
        $users = [];
        \DB::beginTransaction();

        User::where('email', 'agus.jimenez.caba@gmail.com')->firstOr(function () use (&$users) {
            $users[] = [
                'name' => 'Agustin Jimenez',
                'email' => 'agus.jimenez.caba@gmail.com',
                'password' => '12345678',
                'enabled' => true,
                'email_verified_at' => now()->toDateTimeString(),
            ];
        });

        foreach( range(0,50000) as $key ) 
            $users[] = [
                'name' => $faker->name,
                'email' => $faker->unique()->email,
                'password' => $faker->password(),
                'enabled' => true,
                'utr' => $faker->numberBetween(999999, 9999999),
                'email_verified_at' => $faker->dateTimeBetween('-10 years', 'now'),
            ];
        foreach(array_chunk($users, 5000) as $users_chunk)
            User::insert($users_chunk);

        \DB::commit();
    }
}
