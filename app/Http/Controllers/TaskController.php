<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use Illuminate\support\Facades\Auth;
use App\Notifications\TaskCreateNotification;
 use App\Notifications\UpdateTaskNotification;

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
       
         if ($req->wantsJson()) {
        return response()->json([
            'success' => true,
            'data' => $tasks
        ]);
           }
        return view('task.index',compact('tasks'));

        
    }

      public function task_edit($id)
      {
        $task=Task::with('assignedUser')->findOrFail($id);
        $this->authorize('view',$task);
        $users = User::where('role','user')->get();

        return view('task.edit',compact('task','users'));

      }
    

        public function status_update(Request $req,$id)
    {
    //    dd($req->all());
           $data=Task::findOrFail($id);
           $data->status=$req->status;
           $data->comments=$req->comments ?? '';
           if($data->isDirty())
           {
             $data->save();
             return back()->with('success','Task Updated Successfully');
           }
           return back()->with('success','No Changes');
      


    }
      public function task_update(Request $req,$id)
      {
         $task=Task::with('assignedUser')->findOrFail($id);
          $this->authorize('update',$task);
         $task->title=$req->title;
         $task->description= $req->description;
         $task->due_date=     $req->due_date;
         $task->assigned_to=  $req->assigned_to;
         $task->status=       $req->status;
         
         
         $task->update();
         $notify_user=User::find($task->assigned_to);
         $notify_user->notify(new UpdateTaskNotification( $task->id,$task->title));
         return redirect()->route('task.index')->with('success','Task Updated Successfully');
      }

      public function task_delete(Request $req,$id)
      {
         $task=Task::with('assignedUser')->findOrFail($id);
          $this->authorize('delete', $task);
         $task->delete();
        return redirect()->route('task.index')->with('success','Task Deleted Successfully');

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
        'priority' => 'required',
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
        $task->priority= $validated['priority'];
        $task->save();
        $notify_user=User::find($task->assigned_to);
        $notify_user->notify(new TaskCreateNotification( $task->id,$task->title));
        return redirect()->route('task.index')->with('success', 'Task created successfully!');
         
      }

       public function show_task($id)
      {
          $task = Task::findOrFail($id);
          $user = auth()->user();
          if (request()->wantsJson()) {
          return response()->json(['success' => true, 'data' => $task]);
          }
          if ( $user->id == $task->assigned_to) {
              return view('task.show', compact('task'));
          }
          
          session()->flash('error', 'Unauthorized. Please login with correct account.');
          auth()->logout();
          return redirect()->route('homepage');

      }

      public function update_priority(Request $request,$id)
      {
        $task=Task::findOrFail($id);
        $task->priority=$request->priority;
        $task->update();
        return back()->with('success','Priority Status changed');
      }


}
