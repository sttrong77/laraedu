<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\SON\User::class)->create([
            'email'=>'admin@email.com',
            'enrolment'=>100000

        ]);
    }
}
