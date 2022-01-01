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
        //
        for($i = 0;$i<50;$i++){
            factory(App\User::class)->create();
        }
       // return factory(App\User::class)->create();

    }
}
