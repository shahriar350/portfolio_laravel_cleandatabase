<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Validator;

class SuperadminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a super user for admin panel';

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
        if (User::count() === 0) {
            $name = $this->ask('What is your name?');
            $email = $this->ask('What is your email?');
            $password = $this->ask('What is your password?');
            $validator = Validator::make(
                array(
                    'name' => $name,
                    'password' => $password,
                    'email' => $email
                ),
                array(
                    'name' => 'required',
                    'password' => 'required|min:8',
                    'email' => 'required|email|unique:users'
                )
            );
            if ($validator->fails()) {
                $this->info($validator->messages());
            } else {

                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => bcrypt($password),
                ]);
                if ($user) {
                    $this->info('Hello '.$name.', Your account is created successfully.here is your information:');
                    $this->info('name: '.$name);
                    $this->info('email: '.$email);
                    $this->info('password: '.$password);
                    $this->info('To login goto admin panel "/admin" and use your email and password. Thank you :)');
                }
            }
        } else {
            $this->info('Only one user can handle this website. To reset your information login or use forget password to update your information');
        }

        return 0;
    }
}
