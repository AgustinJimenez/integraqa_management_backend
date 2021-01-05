<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::firstOrNew([
            'name' => 'Agustin Jimenez',
            'email' => 'agus.jimenez.caba@gmail.com',
            'password' => '12345678',
        ]);
    }
}
