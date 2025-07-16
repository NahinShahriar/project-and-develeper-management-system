<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    
      public function send_mail(Request $req,$id)
      {
        $user= User::find($id);
         
        Mail::to($user->email)->send();

      }
}
