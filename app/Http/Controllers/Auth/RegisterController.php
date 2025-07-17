<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordsetMail;
use Illuminate\Support\Facades\Password;
class RegisterController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
   

     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate=$request->validate(
            [ 
                'name'=>'required|string',
                'email'=>'required|unique:users,email',
            ]
            );
             $random_password=Str::random(12);
            //  dd( $random_password);
            $validate['password']=Hash::make($random_password);
            $user=new User($validate);
            $user->name=$request->name;
            $user->email=trim($request->email);  
            $user->save();  
            $token = Password::createToken($user);
            $link = url(route('password.reset', ['token' => $token, 'email' => $user->email], false));
            Mail::to($user->email)->send(new PasswordsetMail( $user->name,$random_password,$link)); 
            return redirect()->route('users.index')->with('success','User Added  and mail sent Successfully');
     }

    
}
