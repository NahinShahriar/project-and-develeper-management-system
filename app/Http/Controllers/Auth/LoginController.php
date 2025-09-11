<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    
     public function showLoginForm()
    {
        return view('welcome');
    }
   public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $remember = $request->has('remember');

    // Attempt login
    if (Auth::attempt($credentials, $remember)) {
        $request->session()->regenerate();

        if ($remember) {
            // Set cookies for email and password
            Cookie::queue('remembered_email', $request->email, 43200); // 30 days
            Cookie::queue('remembered_password', $request->password, 43200);
        } else {
            Cookie::queue(Cookie::forget('remembered_email'));
            Cookie::queue(Cookie::forget('remembered_password'));
        }

        // Store user info in session
        session([
            'user_id'   => auth()->user()->id,
            'user_name' => auth()->user()->name,
            'email'     => auth()->user()->email,
        ]);

        // Redirect based on role
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'pm') {
            return redirect()->route('dashboard')->with('success', 'Login Successfully');
        } else {
            return redirect()->route('task.index')->with('success', 'Login Successfully');
        }
    }

    // Wrong credentials case
    return back()->withErrors([
        'error' => 'Invalid Credentials',
    ])->withInput();
}

     public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('homepage')->with('success','Logout Successfully');
    }
}
