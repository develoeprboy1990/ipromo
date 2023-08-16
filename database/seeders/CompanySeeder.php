<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $compArr = [

                'Name' => 'Extensive IT Services',
                'Name2' => '(PVT) LTD',
                'TRN' => '123456789',
                'Currency' => 'AED',
                'Contact' => '+971 4 584 8310',
                'Email' => 'info@eits.ae',
                'Website' => 'www.eits.ae',
                'Address' => 'Office #1807 Clover Bay Tower, Business Bay - Dubai',
                'Logo' => '1680632089.png',
                'BackgroundLogo' => '1680632089.png',
        ];

        $comp = Company::count();

        if($comp == 0){
            Company::create($compArr);
        }
    }
}
