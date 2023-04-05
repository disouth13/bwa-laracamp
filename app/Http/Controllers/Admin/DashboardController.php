<?php

namespace App\Http\Controllers\Admin;

use App\Models\Checkout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //index
    public function index()
    {
        $checkouts = Checkout::with('Camp')->get();
        return view('pages.backend.admin.dashboard', [
            'checkouts' => $checkouts,
        ]);
    }
}
