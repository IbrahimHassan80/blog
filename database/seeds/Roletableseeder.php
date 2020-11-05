<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use Faker\Factory;
class Roletableseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = Factory::create();

       $adminRole = Role::create([
       	'name' => 'admin',
       	'display_name' => 'Administrator',
       	'description' => 'system Administrator',
       	'allowed_route' => 'admin',]);
   
   		$editorRole = Role::create([
       	'name' => 'editor',
       	'display_name' => 'SuperVisor',
       	'description' => 'system SuperVisor',
       	'allowed_route' => 'admin',]);

       	$userRole = Role::create([
       	'name' => 'user',
       	'display_name' => 'user',
       	'description' => 'Normal User',
       	'allowed_route' => null,]);
       	
       	/// users ///---------------------------------------------
       	
       	$admin = User::create([
 		'name' => 'Admin',
		'username' => 'Admin',
		'email'  =>	'admin@yahoo.com',
		'mobile'	=> '01278552735',
		'email_verified_at' => Carbon::now(),
		'password' => bcrypt('123123123'),
		'status'	=> 1,
       	]);
       	$admin->attachRole($adminRole);

       	$editor = User::create([
 		'name' => 'editor',
		'username' => 'editor',
		'email'  =>	'editor@yahoo.com',
		'mobile'	=> '01278552791',
		'email_verified_at' => Carbon::now(),
		'password' => bcrypt('123123123'),
		'status'	=> 1,
       	]);
       	$editor->attachRole($editorRole);

       	$user1 = User::create([
 		'name' => 'ibrahim hassan',
		'username' => 'himaaaaaa',
		'email'  =>	'hima@yahoo.com',
		'mobile'	=> '01278552765',
		'email_verified_at' => Carbon::now(),
		'password' => bcrypt('123123123'),
		'status'	=> 1,
       	]);
       	$user1->attachRole($userRole);


       	$user2 = User::create([
 		'name' => 'mohamed fouad',
		'username' => 'fo2sh',
		'email'  =>	'fo2sh@yahoo.com',
		'mobile'	=> '01278552700',
		'email_verified_at' => Carbon::now(),
		'password' => bcrypt('123123123'),
		'status'	=> 1,
       	]);
       	$user2->attachRole($userRole);

       	$user3 = User::create([
 		'name' => 'mohamed sameh',
		'username' => 'aboelswabe7',
		'email'  =>	'sameh@yahoo.com',
		'mobile'	=> '01278552967',
		'email_verified_at' => Carbon::now(),
		'password' => bcrypt('123123123'),
		'status'	=> 1,
       	]);
       	$user3->attachRole($userRole);

       	for($i=0; $i<10; $i++) {
       		$user = User::create([
       			'name' => $faker->name,
       			'username' => $faker->username,
       			'email' => $faker->email,
       			'mobile' => '012' . random_int(10000, 999999),
       			'email_verified_at' => Carbon::now(),
				'password' => bcrypt('123123123'),
				'status'	=> 1,
       	]);	
       	$user->attachRole($userRole);
       	}

    }
}//
