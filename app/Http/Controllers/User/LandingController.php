<?php

namespace App\Http\Controllers\User;

use App\Models\Camps;
use App\Models\CampBenefit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LandingController extends Controller
{
    //
    public function LandingIndex(Request $request)
    {
        $camps = Camps::all();

        return view('welcome', compact('camps'));
    }
}
