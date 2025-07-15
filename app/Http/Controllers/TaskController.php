<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use Illuminate\support\Facades\Auth;
use App\Notifications\TaskCreateNotification;

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
       

        return view('task.index',compact('tasks'));
    }

      public function task_edit($id)
      {
        $task=Task::with('assignedUser')->findOrFail($id);
        $users = User::where('role','user')->get();

        return view('task.edit',compact('task','users'));

      }

      public function task_update(Request $req,$id)
      {
         $task=Task::with('assignedUser')->findOrFail($id);
         $task->title=$req->title;
         $task->description= $req->description;
         $task->due_date=     $req->due_date;
         $task->assigned_to=  $req->assigned_to;
         $task->status=       $req->status;
         
         
         $task->update();
         return redirect()->route('task.index');
      }

      public function task_delete(Request $req,$id)
      {
         $task=Task::with('assignedUser')->findOrFail($id);
         $task->delete();
          return redirect()->route('task.index');

      }
    public function task_create()
    {
          $users=User::where('role','user')->get();
          $projects=Project::get();
          return view('task.add',compact('users','projects'));
    }
      public function task_store(Request $req)
      {
       
         $validated = $req->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'due_date' => 'required|date',
        'status' => 'required|in:todo,in_progress,done',
         'project_id' => 'required|exists:projects,id',
        'assigned_to' => 'required|exists:users,id',
        ]);
        $assigned_by=Auth::id();
        // dd( $assigned_by);
        $task = new Task();
        $task->title = $validated['title'];
        $task->description = $validated['description'];
        $task->due_date = $validated['due_date'];
        $task->status = $validated['status'];
        $task->project_id = $validated['project_id'];
        $task->assigned_to = $validated['assigned_to'];
        $task->assigned_by= $assigned_by;
        $task->save();
        $notify_user=User::find($task->assigned_to);
        $notify_user->notify(new TaskCreateNotification( $task->id,$task->title));
        return redirect()->route('task.index')->with('success', 'Task created successfully!');
         
      }

       public function show_tasks($id)
      {
          $task = Task::findOrFail($id);
          $user = auth()->user();

          if ( $user->id == $task->assigned_to) {
              return view('task.show', compact('task'));
          }

          session()->flash('error', 'Unauthorized. Please login with correct account.');
          auth()->logout();
          return redirect()->route('homepage');

      }


}
