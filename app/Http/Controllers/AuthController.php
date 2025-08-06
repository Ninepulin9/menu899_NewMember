<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

   public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    // ดึง user พร้อมความสัมพันธ์กับ categories
    $user = User::where('email', $request->email)->with('categories')->first();

    if ($user && Hash::check($request->password, $user->password)) {
        Session::put('user', $user); 

        if ($user->role === 'owner') {
            return redirect('/admin');
        }

        if (in_array($user->role, ['manager', 'cashier', 'staff', 'user'])) {
            return redirect('/admin/memberorder');
        }

        return redirect('/delivery');
    }

    return back()->withErrors(['email' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง']);
}


    public function logout()
    {
        Session::forget('user');
        return redirect('/admin/login');
    }
}
