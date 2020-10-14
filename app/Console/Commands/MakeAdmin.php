<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin {login} {pass}';

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
     * @return mixed
     */
    public function handle()
    {
        $login = $this->argument("login");
        $pass = $this->argument("pass");

        $u = new \App\Models\User();
        $u->email = $login;
        $u->password = Hash::make($pass);
        $u->username = $login;
        $u->type = "user";
        $u->system_admin = 1;
        /*
        $u->lastname = "Admin";
        $u->city = "";
        $u->address = "";
        $u->post = "";
        $u->country = "";
        */
        $u->save();

        echo "User created";
    }
}
