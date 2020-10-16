<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    function login() {
        return view('admin.auth.login');
    }
    function loginnow(Request $request) {
        $request->validate([
            'email' => 'email|required',
            'password' => 'required|string'
        ]);
        if (\Auth::attempt(['email' => $request->email,'password' => $request->password])) {
            return redirect()->route('admin.index');
        } else {
            return back()->with('error_message','Email and Password are invalid');
        }
    }
    function logout() {
        auth()->logout();
        return redirect()->route('login');
    }
}
