<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class Testphp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::firstOrNew([
            'name' => 'Agustin Jimenez',
            'email' => 'agus.jimenez.caba@gmail.com',
            'password' => '12345678',
        ]);
        dd(
            $user->toArray()
        );

        return 0;
    }
}
