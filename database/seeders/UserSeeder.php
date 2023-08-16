<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userArr = [

            [
                'FullName' => 'Kashif Mushtaq',
                'Email' => 'demo@extbooks.com',
                'Password' => '123456',
                'UserType' => 'Admin',
                'Active' => 'Yes'
            ],
            [
                'FullName' => 'User 1',
                'Email' => 'user@extbooks.com',
                'Password' => '123456',
                'UserType' => 'User',
                'Active' => 'Yes'
            ],
            [
                'FullName' => 'User 2',
                'Email' => 'user2@extbooks.com',
                'Password' => '123456',
                'UserType' => 'User',
                'Active' => 'Yes'
            ]

        ];

        $users = User::count();

        if($users == 0){

            foreach($userArr as $arr){

                User::create($arr);
            }
        }
    }
}
