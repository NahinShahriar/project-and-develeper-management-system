<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordsetMail;
use Illuminate\Support\Facades\Password;

class UserManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {  
        $query=User::query();
        if($request->has('search') && !empty($request->search))
        {
           $query->where('name','like','%'.$request->search.'%')
           ->orWhere('email','like','%'.$request->search.'%');
        }
        $users=$query->where('role','user')->paginate(10);
        return view('user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     return view('user.create');
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     $validate=$request->validate(
    //         [ 
    //             'name'=>'required|string',
    //             'email'=>'required|unique:users,email',
    //         ]
    //         );
    //          $random_password=Str::random(12);
    //         //  dd( $random_password);
    //         $validate['password']=Hash::make($random_password);
    //         $user=new User($validate);
    //         $user->name=$request->name;
    //         $user->email=trim($request->email);  
    //         $user->save();  
    //         $token = Password::createToken($user);
    //         $link = url(route('password.reset', ['token' => $token, 'email' => $user->email], false));
    //         Mail::to($user->email)->send(new PasswordsetMail( $user->name,$random_password,$link)); 
    //         return redirect()->route('users.index')->with('success','User Added  and mail sent Successfully');
    //  }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {  $user=User::findOrFail($id);
        return view('user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
            return redirect()->route('users.index')->with('success','User Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $user=User::findOrFail($id);
         $user->delete();
         return redirect()->route('users.index')->with('success','User Deleted Successfully');
    }
}
