<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Experience;
use App\Project;
use App\Material;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class MaterialController extends Controller
{
    /**
     * Display a listing of materials of a given experience.
     *
     * @return void
     */
    public function index($id_user,$id_project,$id_experience)
    {
        $project = Project::findorFail($id_project);
        $experience = Experience::findorFail($id_experience);
        if(Auth::id()==$id_user && Auth::id()== $project->id_user && $project->id == $experience->id_project){
            $material = Material::where('id_experience', $id_experience)->paginate(15);
    
            return view('project.material.index', compact('material', 'id_project', 'id_experience' ));
        }else{
                Auth::logout();
                return view('home');
        }
    }

    /**
     * Show the form for creating a new Material.
     *
     * @return void
     */
    public function create($id_user,$id_project,$id_experience)
    {
        $project = Project::findorFail($id_project);
        $experience = Experience::findorFail($id_experience);
        if(Auth::id()==$id_user && Auth::id()== $project->id_user && $project->id == $experience->id_project){
            $data['id_experience'] = $id_experience;
            $data['id_project'] = $id_project;
            
            return view('project.material.create', compact('data','id_experience','id_project'));
        }else{
                Auth::logout();
                return view('home');
        }
    }

    /**
     * Store a newly created material in storage.
     *
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required', ]);

        $material = Material::create($request->all());
        
        $experience = Experience::findorFail($material->id_experience);
        
        $experience->tem_material = 1;
        $experience->update();

        Session::flash('flash_message', 'Material added!');

        return redirect($request->id_user . '/project/' . $request->id_project . '/experience/' . $request->id_experience . '/material/' );
    }

    /**
     * Display the specified material.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function show($id_user,$id_project,$id_experience,$id_material)
    {
        $project = Project::findorFail($id_project);
        $experience = Experience::findorFail($id_experience);
        if(Auth::id()==$id_user && Auth::id()== $project->id_user && $project->id == $experience->id_project){
            $material = Material::findOrFail($id_material);
         
            $data['id_project'] = $id_project;
    
            return view('project.material.show', compact('material','data'));
        }else{
                Auth::logout();
                return view('home');
        }
    }

    /**
     * Show the form for editing the specified material.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function edit($id_user,$id_project,$id_experience,$id_material)
    {
        $project = Project::findorFail($id_project);
        $experience = Experience::findorFail($id_experience);
        if(Auth::id()==$id_user && Auth::id()== $project->id_user && $project->id == $experience->id_project){
            $material = Material::findOrFail($id_material);
    
            return view('project.material.edit', compact('material','id_project','id_experience'));
        }else{
                Auth::logout();
                return view('home');
        }
    }

    /**
     * Update the specified material in storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function update($id, Request $request)
    {
        $this->validate($request, ['name' => 'required', ]);

        $material = Material::findOrFail($id);
        $material->update($request->all());

        Session::flash('flash_message', 'Material updated!');

        return redirect($request->id_user . '/project/' . $request->id_project . '/experience/' . $request->id_experience . '/material/');

    }

    /**
     * Remove the specified material from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function destroy($id,Request $request)
    {
        Material::destroy($id);

        Session::flash('flash_message', 'Material deleted!');

        return redirect($request->id_user . '/project/' . $request->id_project . '/experience/' . $request->id_experience . '/material/');
    }
}
