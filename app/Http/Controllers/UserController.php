<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function index()
    {
        return view('dashboard');
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

    public function logout()
    {
        Auth::logout();
        return redirect()->route('homepage');
    }


    public function task_update(Request $req,$id)
    {
    //    dd($req->all());
           $data=Task::findOrFail($id);
           $data->status=$req->status;
           $data->save();
           return back();


    }
//    public function create(Request $request, $token)
//    {
//         // { if(Auth::check())
//         //     {
//         //         return  user or admin      eta akta upay
//         //     }
//             Auth::logout();
//             $email = $request->email;
//             return view('password_set', compact('token', 'email'));
//         }
public function create(Request $request, $token)
{
    // Force logout if someone is logged in
    if (Auth::check()) {
        Auth::logout();
    }

    $email = $request->query('email'); // get ?email=user@gmail.com

    // (Optional but recommended) check if token exists
    $exists = DB::table('password_resets')
                ->where('email', $email)
                ->where('token', $token)
                ->exists();

    if (!$exists) {
        return redirect()->route('login.form')
            ->with('error', 'This password reset link is invalid or expired.');
    }

    return view('password_set', compact('token', 'email'));
}



     public function password_update(Request $request)
    {
        $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|confirmed|min:8',
    ]);

    // 2. Attempt to reset the password using Laravel's built-in Password facade
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            // 3. Update the user's password (hashed) in the users table
            $user->forceFill([
                'password' => Hash::make($password),
            ])->save();
        }
    );

    // 4. Check if password reset was successful
    if ($status == Password::PASSWORD_RESET) {
        // Redirect to login with success message
        return redirect()->route('login.form')->with('success', 'Your password has been set successfully!');
    } else {
        // Redirect back with error message
        return back()->withErrors(['email' => [__($status)]]);
    }
    }

    public function showLoginForm()
    {
        return view('welcome');
    }
     public function profile()
    {
        return view('user.profile');
    }

    public function showChangePasswordForm()
    {
        return view('user.password_change');
    }

    public function ChangePassword(Request $request)
    {
        $validate=$request->validate([
            'password'=>'required',
            'new_password'=>'required|confirmed',

        ]);
        if(!Hash::check($request->password,Auth::user()->password))
        {
            return back()-> withErrors([
                'error'=>"Current Passowrd Does not Match",
            ]);
        }
       Auth::user()->update([
        'password' => Hash::make($request->new_password),
    ]);
        return back()->with('success', 'Password changed successfully!');
    }
}
