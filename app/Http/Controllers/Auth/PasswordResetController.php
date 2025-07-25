<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\ForgetPasswordMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class PasswordResetController extends Controller
{
    public function view()
    {
        return view('auth.forgot_password');
    }


    public function send_mail(Request $request)
    {
        $user=User::where('email',$request->email)->first();
        if($user)
        {
            $token=Str::random(16);
            DB::table('password_resets')->insert([
                'email'=>$user->email,
                'token'=>$token,
                'created_at'=>now(),
            ]);
            Mail::to($request->email)->send(new ForgetPasswordMail($user,$token));
            return back()->with('status','Mail Sent');
        }

        return back()->with('status','No Email Found');
    }

    public function view_page(Request $request,$token)
    {   
        $email=$request->query('email');
       $check_token= DB::table('password_resets')
                                    ->where('email',$email)
                                   ->where('token',$token)
                                   ->first();
       if(!$check_token)
       {
          return redirect()->route('homepage')->with('error','Your Link Expired');
       }
        return view('auth.reset_page',['token'=>$token,'email'=>$email]);
    }

    public function update_password(Request $request,$token)
    {
        $validated=$request->validate([
            'email'=>'required|email',
            'password'=>'required|confirmed',

        ]);

         $passwordReset = DB::table('password_resets')
        ->where('email', $request->email)
        ->where('token', $token)
        ->first();

        if (!$passwordReset) {
            return back()->withErrors(['error' => 'Invalid or expired password reset token.'])->withInput();
        }
        $user=User::where('email',$validated['email'])->first();
        if($user)
        {
            $user->password=Hash::make($validated['password']);
            $user->save();
            DB::table('password_resets')->where('email',$validated['email'])->delete();
            return redirect()->route('homepage')->with('success','Password Changed Success .Please Login!');
           
        }
        return Back()->withErrors(['error'=>'Invalid Email']);
    }
}
