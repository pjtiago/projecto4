<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Project;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects.
     *
     * @param  int  $id_user
     *
     * @return void
     */
    public function index($id_user)
    {
        if(Auth::id()==$id_user){
            $data['id_user'] = $id_user;   
            $project = Project::where('id_user', $data['id_user'])->paginate(15);
                
            return view('project.project.index', compact('project'));
        }else{
            Auth::logout();
            return view('home');
        }
    }
    /**
     * Show the about page
     *
     * @return void
     */
    public function aboutPage()
    {
       return view('project.project.about');
    }

    /**
     * Show the form for creating a new project.
     *
     * @return void
     */
    public function create()
    {
       return view('project.project.create');
    }

    /**
     * Store a newly created project in storage.
     *
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required', 'description' => 'required','id_user'=>'required' ]);

        Project::create($request->all());

        Session::flash('flash_message', 'Project added!');

        return redirect($request->id_user . '/project');
    }

    /**
     * Display the specified project.
     *
     * @param  int  $id_user
     * @param  int  $id_proj
     *
     * @return void
     */
    public function show($id_user, $id_proj)
    {
        if(Auth::id()==$id_user){
            $project = Project::findOrFail($id_proj);
    
            return view('project.project.show', compact('project'));
        }else{
            Auth::logout();
            return view('home');
        }
    }

    /**
     * Show the form for editing the specified project.
     *
     * @param  int  $id_user
     * @param  int  $id_proj
     *
     * @return void
     */
    public function edit($id_user, $id_proj)
    {
        if(Auth::id()==$id_user){
            $project = Project::findOrFail($id_proj);
          
            return view('project.project.edit', compact('project'));
        }else{
            Auth::logout();
            return view('home');
        }
    }

    /**
     * Update the specified project in storage.
     *
     * @param  int  $id_project
     *
     * @return void
     */
    public function update($id_project, Request $request)
    {
        echo $id_project;
        echo $request;
        $this->validate($request, ['name' => 'required', 'description' => 'required', ]);
        $project = Project::findOrFail($id_project);
        $project->update($request->all());

        Session::flash('flash_message', 'Project updated!');

        return redirect($request->id_user .  '/project');
    }

    /**
     * Remove the specified project from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function destroy($id, Request $request)
    {
        Project::destroy($id);

        Session::flash('flash_message', 'Project deleted!');

        return redirect($request->id_user . '/project');
    }
}
