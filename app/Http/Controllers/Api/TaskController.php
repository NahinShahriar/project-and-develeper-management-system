<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use Illuminate\support\Facades\Auth;

class TaskController extends Controller
{
    public function index( Request $req)
    {
        //dd(Auth::id());
        $query=Task::with('assignedUser','assignbyUser');
        // $tasks=dd(Task::with('assignedUser')->where('assigned_to','=',Auth::id())->toSql());
       if(Auth::user()->role=='user')
       {
         $tasks=$query->where('assigned_to','=',Auth::id())->get();
       }
        if($req->has('search')&&!empty($req->search))
        {
          $query->where('title','like','%'.$req->search.'%')
           ->orWhere('description', 'like', '%' . $req->search . '%');
        }
     
         $tasks=$query->paginate(10);
       
        return response()->json([
            'success' => true,
            'data' => $tasks
        ]);
           
      

        
    }
 


}
