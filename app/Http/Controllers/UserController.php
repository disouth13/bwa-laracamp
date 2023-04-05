<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;


use Mail;
use App\Mail\User\mailAfterRegister;

class UserController extends Controller
{
    //login
    public function login()
    {
        return view('auth.user-login.login');
    }

    // login with google
    public function LoginGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // handle provider callback setelah berhasil login
    public function HandleProviderCallback()
    {
        //mengambil data user login
        $callback = Socialite::driver('google')->stateless()->user();
        $data = [
            'name'              => $callback->getName(),
            'email'             => $callback->getEmail(),
            'avatar'             => $callback->getAvatar(),
            'email_verified_at' => date('Y-m-d H:i:s', time()),
        ];

        // dd($data);
        //jika sudah ada email user tidak ditambahkan jika tidak ada maka akan ditambahkan
        // $user = User::firstOrCreate(['email' => $data['email']], $data);

        // menggunakan email notification
        $user = User::whereEmail($data['email'])->first();
        // cek user jika tidak ada email maka akan di create baru sebagai register
        if(!$user){
            $user = User::create($data);
            Mail::to($user->email)->send(new mailAfterRegister($user));
        }
        Auth::login($user, true);

        return redirect(route('welcome'));
    
    }
}
