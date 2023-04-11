<?php

namespace App\Http\Controllers\User;


use Mail;
use Midtrans;
use Midtrans\Snap;
use Midtrans\Config;

use App\Models\Camps;
use App\Models\Checkout;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Mail\Checkout\mailAfterCheckout;
use App\Http\Requests\User\Checkout\ValidasiStore;

class CheckoutController extends Controller
{


    // config midtrans
        public function __construct()
        {
            Config::$serverKey = env('MIDTRANS_SERVERKEY');
            Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
            Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
            Config::$is3ds = env('MIDTRANS_IS_3DS');
        }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Camps $camp, Request $request)
    {


        //validasi
        if($camp->isRegistered) {
            $request->session()->flash('error', "You already registered on {$camp->title} camp.");
            return redirect()->route('user.dashboard');
        }
        
        return view('pages.frontend.checkout.checkout', [
            'camp'  => $camp
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidasiStore $request, Camps $camp)
    {

        // // validasi store
        // return $request->all();

        //mapping request data
        $data = $request->all();
        
        $data['user_id'] = Auth::id();
        $data['camp_id'] = $camp->id;

        // update user data
        $user = Auth::user();
        $user->email = $data['email'];
        $user->name = $data['name'];
        $user->occupation = $data['occupation'];
        $user->phone = $data['phone'];
        $user->address = $data['address'];
        $user->save();

        // create chcekout
        $checkout = Checkout::create($data);

        // midtrans
        $this->getSnapMidtransRedirect($checkout);

        // send email after checkout
        // Mail::to(Auth::user()->email)->send(new mailAfterCheckout($checkout));

        return redirect()->route('checkout-success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function show(Checkout $checkout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function edit(Checkout $checkout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Checkout $checkout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function destroy(Checkout $checkout)
    {
        //
    }

    // chcekout-success
    public function success()
    {
        return view('pages.frontend.checkout.success-checkout');
    }

    // get invoice
    public function invoice(Checkout $checkout)
    {
        return $checkout;
    }

    /**
     * Midtrasn handler
     */ 
    public function getSnapMidtransRedirect(Checkout $checkout)
    {
        // variable
        $orderID = $checkout->id.'-'.Str::random(6);
        $price = $checkout->Camp->price * 1000;
        
        $checkout->midtrans_booking_code = $orderID;

        $transaction_details = [
            'order_id'      => $orderID,
            'gross_amount'  => $price,
        ];

        $item_details[] = [
            'id'            => $orderID,
            'price'         => $price,
            'quantity'      => 1,
            'name'          => "Payment for {$checkout->Camp->title} Camp",

        ];

        $userData = [
            "first_name" => $checkout->User->name,
            "last_name" => "",
            "address" => $checkout->User->phone,
            "country_code" => "IDN",
        ];

        $customer_details = [
            "first_name" => $checkout->User->name,
            "last_name" => "",
            "email" => $checkout->User->email,
            "phone" => $checkout->User->phone,
            "country_code"  => "IDN",
        ];

        $midtrans_params = [
            'transaction_details'   => $transaction_details,
            'customer_details'      => $customer_details,
            'item_details'          => $item_details,
        ];


        try{
            // get snap payment url
            $paymentUrl = Snap::createTransaction($midtrans_params)->redirect_url;
            $checkout->midtrans_url = $paymentUrl;
            $checkout->save();

            return $paymentUrl;
        } catch (Exception $e) {
            return false;
        }

        
    }

    /**
     * config midtrans callback
     */
    public function midtransCallback(Request $request)
    {
        // midtrans post dan get kondisional
        $notif = $request->method() == 'POST' ? new Midtrans\Notification() : Midtrans\Transaction::status($request->order_id);

        $transaction_status = $notif->transaction_status;
        $fraud = $notif->fraud_status;

        // check id checkout explode memisahkan karkter '-'
        $checkout_id = explode('-', $notif->order_id)[0];
        $checkout = Checkout::find($checkout_id);

        if ($transaction_status == 'capture') {
            if ($fraud == 'challenge') {
            // TODO Set payment status in merchant's database to 'challenge'
            $checkout->payment_status = 'pending';    

            }
            else if ($fraud == 'accept') {
            // TODO Set payment status in merchant's database to 'success'
            $checkout->payment_status = 'paid';    
            }
        }
        else if ($transaction_status == 'cancel') {
            if ($fraud == 'challenge') {
            // TODO Set payment status in merchant's database to 'failure'
            $checkout->payment_status = 'failed';    
            }
            else if ($fraud == 'accept') {
            // TODO Set payment status in merchant's database to 'failure'
            $checkout->payment_status = 'failed';    
            }
        }
        else if ($transaction_status == 'deny') {
            // TODO Set payment status in merchant's database to 'failure'
            $checkout->payment_status = 'failed';    
        }
        else if ($transaction_status == 'settlement') {
            // TODO set payment status in merchant's database to 'Settlement'
            $checkout->payment_status = 'paid';    
        }
        else if ($transaction_status == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'
            $checkout->payment_status = 'pending';    
        }
        else if ($transaction_status == 'expire') {
            // TODO set payment status in merchant's database to 'expire'
            $checkout->payment_status = 'failed';    
        }

        // save
        $checkout->save();
        return view('checkout/success');
    }
}
