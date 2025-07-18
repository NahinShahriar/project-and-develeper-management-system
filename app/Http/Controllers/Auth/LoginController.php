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
    public function login( Request $request)
    {
        $credentials=$request->validate([
        'email'=>'required|email',
        'password'=>'required',
        ]);

        $remember=$request->has('remember');
        if(Auth::attempt($credentials,$remember))
        {    
        $request->session()->regenerate();
        if ($remember) {
        // Set cookie for email, expires in 1 month
        Cookie::queue('remembered_email', $request->email, 43200); // 43200 minutes = 30 days
        Cookie::queue('remembered_password', $request->password, 43200); // 43200 minutes = 30 days
        } else {
        // Remove cookie if exists
        Cookie::queue(Cookie::forget('remembered_email'));
        Cookie::queue(Cookie::forget('remembered_password'));
        }
        // $userId = auth()->id();
        // $request->session()->put('user_id', $userId);  
        // $request->session()->put('user_name', auth()->user()->name);
        session([
        'user_id'   => auth()->user()->id,
        'user_name' => auth()->user()->name,
        'email'     => auth()->user()->email
         ]);

        if(Auth::user()->role=='admin')
        {      
        return redirect()->route('dashboard')->with('success','Login Successfully'); 
        }
        return redirect()->route('task.index')->with('success','Login Successfully'); 
        }
        else
        {
        return back()->withErrors([
        'error'=>'Inavalid Credentials',
        ])->withInput();
        }

    }
     public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('homepage')->with('success','Logout Successfully');
    }
}
