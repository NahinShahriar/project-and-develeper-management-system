<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{

    // public function index()
    // {  
    //     $projects=Project::count();
    //     $task_assigned=Task::count();
    //     $recent = Task::latest()->take(5)->get();



    //     return view('dashboard',compact('projects','task_assigned','recent'));
    // }
    public function index()
    {
       
        $projects = Project::count();
        $task_assigned = Task::whereIn('status', ['in_progress', 'todo'])->count();
        $recent = Task::latest()->take(5)->get();
        $userName = session('user_name') ?? auth()->user()->name;
        return view('dashboard', compact('projects', 'task_assigned', 'recent'))
        ->with('user_name', $userName);
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
//     public function create(Request $request, $token)
//     {
//     // Force logout if someone is logged in
//     if (Auth::check()) 
//         {
//         Auth::logout();
//         }

//     $email = $request->query('email'); // get ?email=user@gmail.com

//     // (Optional but recommended) check if token exists
//     $exists = DB::table('password_resets')
//                 ->where('email', $email)
//                 ->where('token', $token)
//                 ->exists();

//     if (!$exists) {
//         return redirect()->route('login.form')
//             ->with('error', 'This password reset link is invalid or expired.');
//     }

//     return view('password_set', compact('token', 'email'));
//    }


public function create(Request $request, $token)
{
    if (Auth::check()) {
        Auth::logout();
    }

    $email = $request->query('email');

    $reset = DB::table('password_resets')->where('email', $email)->first();

    if (!$reset || !Hash::check($token, $reset->token)) {
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
   //profile Edit
   public function edit($id)
    {  $user=User::findOrFail($id);
        return view('user.profile_edit',compact('user'));
    }

   // profile update
   /*
    public function update(Request $request, $id)
    {
        $user=User::findOrFail($id);
        $validate=$request->validate(
            [
                  'name'=>'required|string',
                'email' => 'required|unique:users,email,' . $id,
      
            ]
            );
            $user->update($validate);
            return redirect()->route('task.index')->with('success','User Updated Successfully');
    }
            */
    public function update(Request $request, $id)
        {
            $user = User::findOrFail($id);

            $rules = [
                'name' => 'required|string',
            ];

            // Only allow email change if the current user is admin
            if (auth()->user()->role === 'admin') {
                $rules['email'] = 'required|email|unique:users,email,' . $id;
            } else {
                // For non-admin, force email to current one so they can't change it
                $request->merge(['email' => $user->email]);
            }

            $validated = $request->validate($rules);
            $user->update($validated);

            return redirect()->route('task.index')->with('success', 'Profile Updated Successfully');
        }


}
