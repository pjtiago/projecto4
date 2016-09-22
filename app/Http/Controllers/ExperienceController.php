<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Material;
use App\Project;
use App\Line;
use App\Segment;
use App\User;

use Auth;
use App\Experience;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\Facades\Image as Image;
use Maatwebsite\Excel\Facades\Excel as Excel;

class ExperienceController extends Controller
{
    /**
     * Retorna uma view com lista completa das experiencas do utilizador
     *
     * @param  int  $id_user
     * @param  int  $id_project
     * 
     * @return void
     *
     */
    public function index($id_user,$id_project)
    {
        $project = Project::findorFail($id_project);
        
        /* Condição para verificar se o id de utilizador é o mesmo que o id do dono do projecto */
        if(Auth::id()==$id_user && Auth::id()== $project->id_user){
            $experience = Experience::where('id_project', $id_project)->paginate(15);
            $material = Material::all();
            return view('project.experience.index', compact('experience', 'id_project','material'));
        }else{
            Auth::logout();
            return view('home');
        }
        $experience = Experience::where('id_project', $id_project)->paginate(15);
        return view('project.experience.index', compact('experience', 'id_project'));
    }
    
    /**
     * Função gerar folha de excel com os dados da experience
     * 
     * @param  int  $id_user
     * @param  int  $id_project
     * @param  int  $id_experience
     * 
     * @return void
     */
    public function getExcel($id_user,$id_project,$id_experience){
        
        $project = Project::findorFail($id_project);

        if(Auth::id()==$id_user&& Auth::id()== $project->id_user){
            $experience = Experience::findOrFail($id_experience);
            $linhas= Line::where('id_experience',$experience->id)->get();
            $material = Material::where('id_experience', $id_experience)->get();
           
            $excel_info=[];
            $excel_info[] = ["Project"];
            $excel_info[] = ["Name",$project->name];
            $excel_info[] = ["Description",$project->description];
            $excel_info[] = [""];
            $excel_info[] = ["Experience"];
            $excel_info[] = ["Name",$experience->name];
            $excel_info[] = ["Date",$experience->created_at];
            $excel_info[] = [""];
            $excel_info[] = ["Information"];
            $n_linhas = count($linhas);
            $excel_info[] = ["Number of Lines",$n_linhas];
            $excel_info[] = ["Number of Grains",$experience->n_graos];
            
            $n_graos_metro = round(($experience->n_graos / $experience->comprimento_linhas)*1000000, 2);
            $excel_info[] = ["Number of Grains per Meter", $n_graos_metro];
            $tamanho_medio_grao = round((($experience->comprimento_linhas / $experience->n_graos)*1.56), 2);
            $excel_info[] = ["Average Grain Size",$tamanho_medio_grao];
            $excel_info[] = [""];
            $excel_info[] = ["Histogram Data"];
            $excel_info[] = [""];
            $excel_aux_line = [];
            $excel_aux_line[]="class";
            $excel_aux_line[]="Number of Grain";
            
            for($i = 0;$i<count($material);$i++){
                $excel_aux_line[]=$material[$i]->name;
            }
            
            $excel_info[] = $excel_aux_line;
            $max_comp = 0;
            $segmentos=[];
             
            for($i = 0;$i<count($material);$i++){
                $id_mat = $material[$i]->id;
                $seg = Segment::where('id_material', $id_mat)->get();
                for($j = 0;$j<count($seg);$j++){
                    if($seg[$j]->comprimento_segmento >= $max_comp){
                        $max_comp = $seg[$j]->comprimento_segmento;
                    }
                    $segmentos[] = [($seg[$j]->comprimento_segmento * 1.56), $seg[$j]->id];
                }
            }
            $max_comp = ceil($max_comp * 1.56);
            $t_class = floor($max_comp / 10);
            $cont_aux = [];
            for($i = 0;$i<count($material)+1;$i++){
               $cont_aux[] = 0;
            }
            $contadores=[$cont_aux,$cont_aux,$cont_aux,$cont_aux,$cont_aux,$cont_aux,$cont_aux,$cont_aux,$cont_aux,$cont_aux];
            
            for($i = 0;$i<count($segmentos);$i++){
                if($segmentos[$i][0] <= $t_class){
                    $contadores[0][0]++;
                    for($j = 0;$j<count($material);$j++){
                        if($segmentos[$i][0] == $material[$j]->id){
                            $contadores[0][$j+1]++;
                        }
                     }
                }
                if(($segmentos[$i][0] <= $t_class*2) && ($segmentos[$i][0] > $t_class)){
                      $contadores[1][0]++;
                    for($j = 0;$j<count($material);$j++){
                        if($segmentos[$i][0] == $material[$j]->id){
                            $contadores[1][$j+1]++;
                        }
                     }
                }
                if(($segmentos[$i][0] <= $t_class*3) && ($segmentos[$i][0] > $t_class*2)){
                    $contadores[2][0]++;
                    for($j = 0;$j<count($material);$j++){
                        if($segmentos[$i][0] == $material[$j]->id){
                            $contadores[2][$j+1]++;
                        }
                     }
                }
                
                if(($segmentos[$i][0] <= $t_class*4) && ($segmentos[$i][0] > $t_class*3)){
                    $contadores[3][0]++;
                    for($j = 0;$j<count($material);$j++){
                        if($segmentos[$i][0] == $material[$j]->id){
                            $contadores[3][$j+1]++;
                        }
                     }
                }
                if(($segmentos[$i][0] <= $t_class*5) && ($segmentos[$i][0] > $t_class*4)){
                    $contadores[4][0]++;
                    for($j = 0;$j<count($material);$j++){
                        if($segmentos[$i][0] == $material[$j]->id){
                            $contadores[4][$j+1]++;
                        }
                     }
                }
                if(($segmentos[$i][0] <= $t_class*6) && ($segmentos[$i][0] > $t_class*5)){
                    $contadores[5][0]++;
                    for($j = 0;$j<count($material);$j++){
                        if($segmentos[$i][0] == $material[$j]->id){
                            $contadores[5][$j+1]++;
                        }
                     }
                }
                if(($segmentos[$i][0] <= $t_class*7) && ($segmentos[$i][0] > $t_class*6)){
                    $contadores[6][0]++;
                    for($j = 0;$j<count($material);$j++){
                        if($segmentos[$i][0] == $material[$j]->id){
                            $contadores[6][$j+1]++;
                        }
                     }
                }
                if(($segmentos[$i][0] <= $t_class*8) && ($segmentos[$i][0] > $t_class*7)){
                    $contadores[7][0]++;
                    for($j = 0;$j<count($material);$j++){
                        if($segmentos[$i][0] == $material[$j]->id){
                            $contadores[7][$j+1]++;
                        }
                     }
                }
                if(($segmentos[$i][0] <= $t_class*9) && ($segmentos[$i][0] > $t_class*8)){
                    $contadores[8][0]++;
                    for($j = 0;$j<count($material);$j++){
                        if($segmentos[$i][0] == $material[$j]->id){
                            $contadores[8][$j+1]++;
                        }
                     }
                }
                if(($segmentos[$i][0] <= $max_comp) && ($segmentos[$i][0] > $t_class*9)){
                    $contadores[9][0]++;
                    for($j = 0;$j<count($material);$j++){
                        if($segmentos[$i][0] == $material[$j]->id){
                            $contadores[9][$j+1]++;
                        }
                     }
                }
            }
            
            
            
            for($i = 0;$i<count($contadores);$i++){
                $excel_aux_line = [];
                $excel_aux_line[] = $t_class * ($i) . " - " . $t_class * ($i + 1);
                for($j = 0;$j<count($material)+1;$j++){
                    $excel_aux_line[]=$contadores[$i][$j];
                }
                $excel_info[]=$excel_aux_line;
            }
       
            Excel::create('Histogram', function($excel) use($excel_info) {
                    $excel->sheet('Sheet 1', function($sheet) use($excel_info) {
                    $sheet->fromArray($excel_info);
                });
            })->export('xls');
        }else{
            Auth::logout();
            return view('home');
        }
    }
    
    /**
     * Formulario para escolha da escala
     * 
     * @param  int  $id_user
     * @param  int  $id_project
     * @param  int  $id_experience
     * 
     * @return void
     */
    public function getscale($id_user,$id_project,$id_experience)
    {
        $project = Project::findorFail($id_project);
        if(Auth::id()==$id_user&& Auth::id()== $project->id_user){
            $experience = Experience::findOrFail($id_experience);
            return view('getscale', compact('experience'));
        }else{
            Auth::logout();
            return view('home');
        }
    }
    
    /**
     * Formulario para escolha da area de trabalho
     * 
     * @param  int  $id_user
     * @param  int  $id_project
     * @param  int  $id_experience
     * 
     * @return void
     */
    public function getworkspace($id_user,$id_project,$id_experience)
    {
        $project = Project::findorFail($id_project);
        if(Auth::id()==$id_user&& Auth::id()== $project->id_user){
            $experience = Experience::findOrFail($id_experience);
            return view('getworkspace', compact('experience'));
        }else{
            Auth::logout();
            return view('home');
        }
        
    }
    /**
     * Mostra analise e informação da experiencia
     * 
     * @param  int  $id_user
     * @param  int  $id_project
     * @param  int  $id_experience
     * 
     * @return void
     */
    public function experience_information($id_user,$id_project,$id_experience)
    {
        $project = Project::findorFail($id_project);
        if(Auth::id()==$id_user&& Auth::id()== $project->id_user){
            $experience = Experience::findOrFail($id_experience);
            $material = Material::where('id_experience', $id_experience)->get();
            $linhas= Line::where('id_experience',$experience->id)->get();
            $segmentos = array();
            
            for($i = 0;$i<count($material);$i++){
                $id_mat = $material[$i]->id;
                $segmentos[] = Segment::where('id_material', $id_mat)->get();
            }
            $n_linhas = count($linhas);
            $n_graos_linha = $experience->n_graos / $n_linhas;
            $n_graos_linha =  round($n_graos_linha, 2);
            
            /* Conversão de nº de grãos por microns para metro */
            $n_graos_metro = round(($experience->n_graos / $experience->comprimento_linhas)*1000000, 2);
            
            /* Constante para converter o tamanho medio do grão para a realidade (1.56)  */
            $tamanho_medio_grao = round((($experience->comprimento_linhas / $experience->n_graos)*1.56), 2);
            return view('experience_information', compact('project','experience','material','linhas',
            'n_linhas','n_graos_metro','tamanho_medio_grao','segmentos'));
            
        }else{
            Auth::logout();
            return view('home');
        }
        
    }
    
    /**
     * Mostra area de trabalho onde é realizado o trabalho de analisar a imagem 
     * 
     * @param  int  $id_user
     * @param  int  $id_project
     * @param  int  $id_experience
     * 
     * @return void
     */
    public function workspace($id_user,$id_project,$id_experience)
    {
        $project = Project::findorFail($id_project);
        if(Auth::id()==$id_user&& Auth::id()== $project->id_user){
            $experience = Experience::findOrFail($id_experience);
            $material = Material::where('id_experience', $id_experience)->paginate(15);
            $linhas= Line::where('id_experience',$experience->id)->get();
            return view('workspace', compact('experience','material','linhas'));
        }else{
            Auth::logout();
            return view('home');
        }
        
    }
    
    
    /**
     * Mostra formulario para fazer upload da imagem
     * 
     * @param  int  $id_user
     * @param  int  $id_project
     * @param  int  $id_experience
     * 
     * @return void
     */
     public function submitImage($id_user,$id_project,$id_experience)
    {
        $project = Project::findorFail($id_project);
        if(Auth::id()==$id_user&& Auth::id()== $project->id_user){
           $experience = Experience::findOrFail($id_experience);
            return view('project.experience.upload',compact('experience')); 
        }else{
            Auth::logout();
            return view('home');
        }
    }
    
    /**
     * Upload e redimensionamento da imagem da experiencia
     * 
     * @return void
     */
    public function upload(Request $request)
    {
      
      $experience = Experience::findOrFail($request->id_experience);
      // getting all of the post data
      $file = array('image' => Input::file('image'));
      // setting up rules
      $rules = array('image' => 'required',); //mimes:jpeg,bmp,png and for max size max:10000
      // doing the validation, passing post data, rules and the messages
      $validator = Validator::make($file, $rules);
      if ($validator->fails()) {
        // send back to the page with the input data and errors
        Session::flash('error', 'Validation fail');
        return redirect($request->id_user . '/project/' . $request->id_project . '/experience/');
      }
      else {
        // checking file is valid.
        if (Input::file('image')->isValid()) {
            
          $size = getimagesize(Input::file('image'));
          $image = Input::file('image');
          $destinationPath = 'uploadsimages'; // upload path
          $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
          $fileName = round(microtime(true)).'.'.$extension; // renameing image
          $path = base_path().'/public/uploadsimages/' . $fileName;
        if($size[0] > 1366){
            /* Atribuição que o novo tamanho para imagens maiores que 1366px vai ser igual a metade do tamanho original */
            $newSize[0] = $size[0] * 0.5;
            $newSize[1] = $size[1] * 0.5;
            $experience->width = $newSize[0];
            $experience->heigth = $newSize[1];
            Image::make($image->getRealPath())->resize($newSize[0], $newSize[1])->save($path);

            $experience->image_link = "/" . $destinationPath . "/" . $fileName;
            $experience->update();
        
        }else{
          $experience->width = $size[0];
          $experience->heigth = $size[1];
          $experience->image_link = "/" . $destinationPath . "/" . $fileName;
          $experience->update();
          $image->move($destinationPath, $fileName); // uploading file to given path
        }
          // sending back with message
          Session::flash('success', 'Upload successfully'); 
          return redirect($request->id_user . '/project/' . $request->id_project . '/experience/'.$request->id_experience.'/getscale');
        }
        else {
          // sending back with error message.
          Session::flash('error', 'uploaded file is not valid');
          return redirect($request->id_user . '/project/' . $request->id_project . '/experience/'.$request->id_experience.'/getscale');
        }
      }
    }

    /**
     * Show the form for creating a new project
     * 
     * @param  int  $id
     * @param  int  $id_project
     * 
     * @return void
     */
    public function create($id_user,$id_project)
    {
        $project = Project::findorFail($id_project);
        if(Auth::id()==$id_user&& Auth::id()== $project->id_user){
            $data['id_project'] = $id_project; 
            
            return view('project.experience.create',compact('data'));
            
        }else{
            Auth::logout();
            return view('home');
        }
        
    }

    /**
     * Store a newly created project in storage.
     *
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required', ]);

        $experience = Experience::create($request->all());

        Session::flash('flash_message', 'Experience added!');
        
 
        return redirect($request->id_user . '/project/' . $request->id_project . '/experience/' .$experience->id . '/upload');
    }

    /**
     * Display the specified project.
     *
     * @param  int  $id_user
     * @param  int  $id_project
     * @param  int  $id_experience
     *
     * @return void
     */
    public function show($id_user,$id_project,$id_experience)
    {
        $project = Project::findorFail($id_project);
        if(Auth::id()==$id_user&& Auth::id()== $project->id_user){
            $experience = Experience::findOrFail($id_experience);
            return view('project.experience.show', compact('experience'));
        }else{
            Auth::logout();
            return view('home');
        }
        
    }

    /**
     * Show the form for editing the specified project.
     *
     * @param  int  $id_user
     * @param  int  $id_project
     * @param  int  $id_experience
     *
     * @return void
     */
    public function edit($id_user,$id_project,$id_experience)
    {
        $project = Project::findorFail($id_project);
        if(Auth::id()==$id_user&& Auth::id()== $project->id_user){
            $experience = Experience::findOrFail($id_experience);
            return view('project.experience.edit', compact('experience'));
        }else{
            Auth::logout();
            return view('home');
        }
        
    }

    /**
     * Update the specified project in storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function update($id, Request $request)
    {
        $this->validate($request, ['name' => 'required', ]);
        $experience = Experience::findOrFail($id);
        if($request->scale_px){
             $experience->update($request->all());
             Session::flash('flash_message', 'Experience updated!');
             return redirect($request->id_user . '/project/' . $request->id_project . '/experience/' .$experience->id . '/getworkspace/');
        }else if($request->coord_x_workspace){
             $experience->update($request->all());
             Session::flash('flash_message', 'Experience updated!');
             return redirect($request->id_user . '/project/' . $request->id_project . '/experience/' .$experience->id . '/material/create');
        }else{
            $experience->update($request->all());
            Session::flash('flash_message', 'Experience updated!');
            return redirect($request->id_user . '/project/' . $request->id_project . '/experience/');
        }
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
        Experience::destroy($id);
        Session::flash('flash_message', 'Experience deleted!');
        return redirect($request->id_user . '/project/' . $request->id_project . '/experience/');
    }
}
?>