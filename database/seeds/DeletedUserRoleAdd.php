<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeletedUserRoleAdd extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'id' => 99,
            'name' => 'Deleted',
            'description' => 'Deleted users state'
        ]);
    }
}
