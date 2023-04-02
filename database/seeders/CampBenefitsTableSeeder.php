<?php

namespace Database\Seeders;

use App\Models\CampBenefit;
use Illuminate\Database\Seeder;

class CampBenefitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $campBenefits = [
            [
                'camps_id' => 1,
                'name' => 'One to One Mentor'

            ],
            [
                'camps_id' => 1,
                'name' => 'Materi permanent'
                
            ],
            [
                'camps_id' => 1,
                'name' => 'Certificate'
                
            ],

            [
                'camps_id' => 2,
                'name' => 'One to One Mentor'
                
            ],

            [
                'camps_id' => 2,
                'name' => 'Materi Full Update'
                
            ],

            [
                'camps_id' => 1,
                'name' => 'Certificate'
                
            ],

            [
                'camps_id' => 1,
                'name' => 'Free Kaos'
                
            ],

        ];
        CampBenefit::insert($campBenefits);
    }
}
