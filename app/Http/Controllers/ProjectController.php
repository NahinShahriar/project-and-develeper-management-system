<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use App\Notifications\ProjectNotification;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {   
        $query=Project::query();
        if($req->has('search') || !empty($req->search))
        {  
             $search=$req->search;
             $query->where('name','like','%'.$search.'%')
            ->orWhere('description', 'like', '%' . $search . '%');
        }
        $projects=$query->paginate(10);
        $users=User::with('projects')->get();  
        return view('projects.index',['projects'=>$projects,'users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valiedate=$request->validate([
            'name'=>'required|string|max:100',
            'description'=>'required|max:150',
            'start_date'=>'required|date',
            'end_date'=>'required|date',

        ]);
        $user_id=Auth::id();
        $data= new Project();
        $data->name=$valiedate['name'];
        $data->description=$valiedate['description'];
        $data->start_date=$valiedate['start_date'];
        $data->end_date=$valiedate['end_date'];
        $data->created_by=$user_id;
        $data->save();
        $notify_users=User::where('role','=','tl')->get();
        foreach($notify_users as $notify_user)
        {
            $notify_user->notify(new ProjectNotification($data->name) );
        }
       return redirect()->route('projects.index')->with('success', 'Project created successfully!');

    }

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
    {   $projects=Project::findOrFail($id);
        return view('projects.edit',compact('projects'));
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

        // echo "<pre>";
        // print_r($request->all());
        $valiedate=$request->validate([
            'name'=>'required|string|max:100',
            'description'=>'required|max:150',
            'start_date'=>'required|date',
            'end_date'=>'required|date',

        ]);
        $user_id=Auth::id();
        $data=  Project::findOrFail($id);
        $data->name=$valiedate['name'];
        $data->description=$valiedate['description'];
        $data->start_date=$valiedate['start_date'];
        $data->end_date=$valiedate['end_date'];
        $data->created_by=$user_id;
        if ($data->isDirty())
        {
            $data->update();
            return redirect()->route('projects.index')->with('success', 'Project Updated successfully!');
        }
     
       return redirect()->route('projects.index')->with('success', 'No Changes');
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data=  Project::findOrFail($id);
        $data->delete();
        return redirect()->route('projects.index')->with('success', 'Project Deleted successfully!');
    }
}
