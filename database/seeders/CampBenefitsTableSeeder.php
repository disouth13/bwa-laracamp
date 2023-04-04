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
                'camp_id' => 1,
                'name' => 'One to One Mentor'

            ],
            [
                'camp_id' => 1,
                'name' => 'Materi permanent'
                
            ],
            [
                'camp_id' => 1,
                'name' => 'Certificate'
                
            ],

            [
                'camp_id' => 2,
                'name' => 'One to One Mentor'
                
            ],

            [
                'camp_id' => 2,
                'name' => 'Materi Full Update'
                
            ],

            [
                'camp_id' => 1,
                'name' => 'Certificate'
                
            ],

            [
                'camp_id' => 1,
                'name' => 'Free Kaos'
                
            ],

        ];
        CampBenefit::insert($campBenefits);
    }
}
