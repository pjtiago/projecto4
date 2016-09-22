<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Point;
use App\Line;
use App\Segment;
use App\Experience;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class LineController extends Controller
{
    /**
     * Display a listing of the resource. Não Utilizado - gerado automaticamente
     *
     * @return void
     */
    public function index()
    {
        $line = Line::paginate(15);

        return view('project.line.index', compact('line'));
    }
    
    /**
     * Função para inserir linhas, os respectivos pontos da linha e os segmentos
     * 
     * @return void
     */
    public function storeline(Request $request)
    {   
        $array_pontos = $request->input('arr_pontos');
        $experience = Experience::findOrFail($request->input('id_experience'));
        $experience->n_graos += $request->input('numero_clicks');
        $experience->comprimento_linhas += $request->input('comprimento_total_linha');
        $experience->update();
        
        $this->validate($request, ['id_experience'=>'required','coord_x' => 'required', 'coord_y' => 'required', 'angle' => 'required',]);

        $line = Line::create($request->only('id_experience','coord_x','coord_y','angle'));
        $line->n_graos_existentes = $experience->n_graos;
        $line->comprimento_linhas_existentes = $experience->comprimento_linhas;
        $line->update();
        $array_pontos_id = array();
        for ($i=0;$i<count($array_pontos); $i++){
            $point = new Point;
            $point->coord_x = $request->input('arr_pontos.' . $i . '.x');
            $point->coord_y = $request->input('arr_pontos.' . $i . '.y');
            $point->id_line = $line->id;
            $point->save();
            array_push($array_pontos_id, $point->id);
        }
        for ($i=0;$i<(count($array_pontos_id)-1); $i++){
            $segm = new Segment;
            $segm->id_start_point = $array_pontos_id[$i];
            $segm->id_final_point = $array_pontos_id[$i + 1];
            $segm->id_material = $request->input('arr_segments.' . $i . '.material');
            $segm->comprimento_segmento = $request->input('arr_segments.' . $i . '.comprimento');
            $segm->id_line = $line->id;
            
            $segm->save();
        }
        Session::flash('flash_message', 'Experience added!');
    }
    
    /**
     * Show the form for creating a new resource.Não Utilizado - gerado automaticamente
     *
     * @return void
     */
    public function create()
    {
        return view('project.line.create');
    }

    /**
     * Store a newly created resource in storage.Não Utilizado - gerado automaticamente
     *
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate($request, ['coord_x' => 'required', 'coord_y' => 'required', 'angle' => 'required', ]);

        Line::create($request->all());

        Session::flash('flash_message', 'Line added!');

        return redirect('line');
    }

    /**
     * Display the specified resource.Não Utilizado - gerado automaticamente
     *
     * @param  int  $id
     *
     * @return void
     */
    public function show($id)
    {
        $line = Line::findOrFail($id);

        return view('project.line.show', compact('line'));
    }

    /**
     * Show the form for editing the specified resource.Não Utilizado - gerado automaticamente
     *
     * @param  int  $id
     *
     * @return void
     */
    public function edit($id)
    {
        $line = Line::findOrFail($id);

        return view('project.line.edit', compact('line'));
    }

    /**
     * Update the specified resource in storage.Não Utilizado - gerado automaticamente
     *
     * @param  int  $id
     *
     * @return void
     */
    public function update($id, Request $request)
    {
        $this->validate($request, ['coord_x' => 'required', 'coord_y' => 'required', 'angle' => 'required', ]);

        $line = Line::findOrFail($id);
        $line->update($request->all());

        Session::flash('flash_message', 'Line updated!');

        return redirect('line');
    }

    /**
     * Remove the specified resource from storage.Não Utilizado - gerado automaticamente
     *
     * @param  int  $id
     *
     * @return void
     */
    public function destroy($id)
    {
        Line::destroy($id);

        Session::flash('flash_message', 'Line deleted!');

        return redirect('line');
    }
}
