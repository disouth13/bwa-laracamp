<?php

namespace Database\Seeders;

use App\Models\Checkout;
use Illuminate\Database\Seeder;

class PatchCheckoutTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $checkouts = Checkout::whereTotal(0)->get();
        foreach ($checkouts as $key => $itemCheckout) {
            $itemCheckout->update([
                'total' => $itemCheckout->Camp->price
            ]);
        }
    }
}
