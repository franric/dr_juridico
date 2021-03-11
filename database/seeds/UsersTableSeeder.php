<?php

use Illuminate\Database\Seeder;

use App\Entities\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {

        User::create(
            [
                'name'      => 'Administrador',
                'email'  => 'adm@email.com',
                'password'  => bcrypt('R!c@rd01530')
            ]);
        User::create(
            [
                'name'      => 'Dra. Danielle',
                'email'  => 'danielle@email.com',
                'password'  => bcrypt('D25140823')
            ]
        );
    }
}
