<?php

namespace App\Http\Controllers\User;

use App\Models\Camps;
use App\Models\Checkout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //index
    public function index()
    {
    
        $checkouts = Checkout::with('Camp')->whereUserId(Auth::id())->get();
        return view('pages.frontend.user.dashboard', [
            
            'checkouts' => $checkouts,

        ]);
    }
}
