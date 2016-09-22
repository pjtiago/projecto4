@extends('layouts.app')

@section('content')
<div class="container">
    <p><a href="{{ url('/') }}">Home</a>&nbsp>&nbsp<a href="{{ url(Auth::id() . '/project/') }}"> Projects</a>&nbsp>&nbsp<a href="{{ url(Auth::id() . '/project/'. $experience->id_project . '/experience') }}"> Experiences</a>&nbsp> View Experience</p>
    <h1>Experience - {{ $experience->name }}</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tbody>
                <tr>
                    <th>ID.</th><td>{{ $experience->id }}</td>
                </tr>
                <tr><th> {{ trans('experience.name') }} </th><td> {{ $experience->name }} </td></tr>
                <tr><th> {{ trans('experience.image_link') }} </th><td> {{ $experience->image_link }} </td></tr>
                <tr><th> {{ trans('experience.width') }} </th><td> {{ $experience->width }} </td></tr>
                <tr><th> {{ trans('experience.heigth') }} </th><td> {{ $experience->heigth }} </td></tr>
                <tr><th> {{ trans('experience.scale_px') }} </th><td> {{ $experience->scale_px }} </td></tr>
                <tr><th> {{ trans('experience.scale_real') }} </th><td> {{ $experience->scale_real }} </td></tr>
                <tr><th> {{ trans('experience.width_workspace') }} </th><td> {{ $experience->width_workspace }} </td></tr>
                <tr><th> {{ trans('experience.heigth_workspace') }} </th><td> {{ $experience->heigth_workspace }} </td></tr>
                <tr><th> {{ trans('experience.coord_x_workspace') }} </th><td> {{ $experience->coord_x_workspace }} </td></tr>
                <tr><th> {{ trans('experience.coord_y_workspace') }} </th><td> {{ $experience->coord_y_workspace }} </td></tr>

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">
                        <a href="{{ url('experience/' . $experience->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit Experience"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['experience', $experience->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"/>', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Experience',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ));!!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

</div>
@endsection