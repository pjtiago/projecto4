<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Segment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class SegmentController extends Controller
{
    /**
     * Display a listing of the resource.Não Utilizado - gerado automaticamente
     *
     * @return void
     */
    public function index()
    {
        $segment = Segment::paginate(15);

        return view('project.segment.index', compact('segment'));
    }

    /**
     * Show the form for creating a new resource.Não Utilizado - gerado automaticamente
     *
     * @return void
     */
    public function create()
    {
        return view('project.segment.create');
    }

    /**
     * Store a newly created resource in storage.Não Utilizado - gerado automaticamente
     *
     * @return void
     */
    public function store(Request $request)
    {
        
        Segment::create($request->all());

        Session::flash('flash_message', 'Segment added!');

        return redirect('segment');
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
        $segment = Segment::findOrFail($id);

        return view('project.segment.show', compact('segment'));
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
        $segment = Segment::findOrFail($id);

        return view('project.segment.edit', compact('segment'));
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
        
        $segment = Segment::findOrFail($id);
        $segment->update($request->all());

        Session::flash('flash_message', 'Segment updated!');

        return redirect('segment');
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
        Segment::destroy($id);

        Session::flash('flash_message', 'Segment deleted!');

        return redirect('segment');
    }
}
