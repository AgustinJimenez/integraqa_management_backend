<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        foreach(range(1,100) as $i)
            Company::firstOrNew([
                'id' => $i,
                'name' => $faker->company,
            ]);
    }
}
