<?php

namespace App\Http\Controllers\Admin;

use App\Models\Checkout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Mail;
use App\Mail\Checkout\Paid;

class CheckoutController extends Controller
{
    //update checkout admin
    public function update(Request $request, Checkout $checkout)
    {

        $checkout->status_paid = true;
        $checkout->save();

        // send email to user
        Mail::to($checkout->User->email)->send(new Paid($checkout));

        $request->session()->flash('success', "Checkout with Camp {$checkout->Camp->title} has been update!");
        return redirect(route('admin.dashboard'));
        
    }
}
