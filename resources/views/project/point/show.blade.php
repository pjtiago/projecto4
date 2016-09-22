@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Point {{ $point->id }}</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tbody>
                <tr>
                    <th>ID.</th><td>{{ $point->id }}</td>
                </tr>
                <tr><th> {{ trans('point.coord_x') }} </th><td> {{ $point->coord_x }} </td></tr><tr><th> {{ trans('point.coord_y') }} </th><td> {{ $point->coord_y }} </td></tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">
                        <a href="{{ url('point/' . $point->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit Point"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['point', $point->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"/>', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Point',
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