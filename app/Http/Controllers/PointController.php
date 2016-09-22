<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Point;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class PointController extends Controller
{
    /**
     * Display a listing of the resource.Não Utilizado - gerado automaticamente
     *
     * @return void
     */
    public function index()
    {
        $point = Point::paginate(15);

        return view('project.point.index', compact('point'));
    }

    /**
     * Show the form for creating a new resource.Não Utilizado - gerado automaticamente
     *
     * @return void
     */
    public function create()
    {
        return view('project.point.create');
    }

    /**
     * Store a newly created resource in storage.Não Utilizado - gerado automaticamente
     *
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate($request, ['coord_x' => 'required', 'coord_y' => 'required', ]);

        Point::create($request->all());

        Session::flash('flash_message', 'Point added!');

        return redirect('point');
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
        $point = Point::findOrFail($id);

        return view('project.point.show', compact('point'));
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
        $point = Point::findOrFail($id);

        return view('project.point.edit', compact('point'));
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
        $this->validate($request, ['coord_x' => 'required', 'coord_y' => 'required', ]);

        $point = Point::findOrFail($id);
        $point->update($request->all());

        Session::flash('flash_message', 'Point updated!');

        return redirect('point');
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
        Point::destroy($id);

        Session::flash('flash_message', 'Point deleted!');

        return redirect('point');
    }
}
