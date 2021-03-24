<?php

namespace App\Console\Commands;

use App\Http\Repositories\MailRepository;
use App\Mail\UserRegisterConfirmation;
use Illuminate\Console\Command;
use App\Models\{User, VerificationToken};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
        $users = User::
        paginate(5)
        ->toArray()
        ;

        dd(
            $users
        );

        return 0;
    }
}
