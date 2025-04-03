<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminAuthController extends Controller
{
    public function get_adminloginpage()
    {
        return view('admin.modules.signin-dashboard');
    }

    public function login_admin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($request->email === 'admin@bakedspot.com.manahil' && $request->password === 'Admin@123') {
            $admin = User::where('email', 'admin@bakedspot.com.manahil')->first();

            if (!$admin) {
                return back()->with('error', 'Admin account not found.');
            }

            Auth::login($admin);

            return redirect()->route('get-admindashboard')->with('success', 'Welcome Admin!');
        }

        return back()->with('error', 'Invalid credentials.');
    }

    public function logout_admin()
    {
        Auth::logout();
        return redirect()->route('get-adminloginpage')->with('success', 'Logged out successfully.');
    }
}
