<?php

class UsersTableSeeder extends Seeder {

    public function run()
    {
    	// Uncomment the below to wipe the table clean before populating
    	// DB::table('pages')->delete();

        $users = array(
        	array(
        		'username' => 'justin', 
        		'password' => Hash::make('r0x4nn31'), 
        		'email' => 'justin@justinhilles.com'),


        );

        // Uncomment the below to run the seeder
        DB::table('users')->insert($users);
    }

}