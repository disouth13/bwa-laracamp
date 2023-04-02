<?php

namespace Database\Seeders;

use App\Models\Camps;
use Illuminate\Database\Seeder;

class CampsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $camps = [
            [
                'title'         =>  'Advanced Bootcamp',
                'slug'          =>  'advanced-bootcamp',
                'price'         =>  280,
                'created_at'    => date('Y-m-d H:i:s', time()),
                'updated_at'    => date('Y-m-d H:i:s', time()),
            ],
            [
                'title'         => 'Expert Bootcamp',
                'slug'          => 'expert-bootcamp',
                'price'         =>  500,
                'created_at'    => date('Y-m-d H:i:s', time()),
                'updated_at'    => date('Y-m-d H:i:s', time()),
            ],  
        ];

        foreach ($camps as $key => $itemCamp) {
            Camps::create($itemCamp);
        };
    }
}
