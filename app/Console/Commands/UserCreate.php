<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class UserCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {--U|user=} {--E|email=} {--P|password=} {--T|phone}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

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
     * @return void
     */
    public function handle()
    {
        $user = $this->option('user');
        $password = $this->option('password');
        $email = $this->option('email');

        if(!$user){
            $user = $this->ask('Enter login');
        }

        if(!$email){
            $email = $this->ask('Enter email');
        }

        if(!$password){
            $password = $this->secret('Enter password');
        }

        User::create([
            'name' => $user,
            'email' => $email,
            'email_verified_at' => now(),
            'password' => Hash::make($password),
            'remember_token' => Str::random(10),
        ]);

        $this->info('User has created');
    }
}
