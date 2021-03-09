<?php

namespace Database\Seeders;

use App\Models\ActivityType;
use Illuminate\Database\Seeder;

class ActivityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types_codes = ['process', 'estate', 'trade', 'wild_collection', 'aquaculture'];
        foreach ($types_codes as $code)
            ActivityType::where('code', $code)->firstOr(function () use (&$code) {
                ActivityType::create([
                    'code' => $code,
                ]);
            });

    }
}
