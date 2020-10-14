<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = App\Models\User::create([
            // 'first_name'    => 'Eleisha',
            // 'last_name'     => 'Cartlidge',
            'username'      => 'eleisha.cartlidge',
            'email'         => 'eleisha.cartlidge@weareblush.co.uk',
            'role_id'    => 4
        ]);
        $user->password = \Hash::make('weareblush1981');
        $user->save();

        $user = App\Models\User::create([
            // 'first_name'    => 'Daniel',
            // 'last_name'     => 'Fisher',
            'username'      => 'daniel.fisher',
            'email'         => 'daniel.fisher@weareblush.co.uk',
            'system_admin' => 1,
            'role_id'    => 0
        ]);
        $user->password = \Hash::make('weareblush1981');
        $user->save();

        $user = App\Models\User::create([
            // 'first_name'    => 'Martin',
            // 'last_name'     => 'Mulvey',
            'username'      => 'martin.mulvey',
            'email'         => 'martin.mulvey@weareblush.co.uk',
            'system_admin' => 1,
            'role_id'    => 0
        ]);
        $user->password = \Hash::make('weareblush1981');
        $user->save();
    }
}
