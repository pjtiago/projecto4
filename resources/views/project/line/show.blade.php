@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Line {{ $line->id }}</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tbody>
                <tr>
                    <th>ID.</th><td>{{ $line->id }}</td>
                </tr>
                <tr><th> {{ trans('line.coord_x') }} </th><td> {{ $line->coord_x }} </td></tr><tr><th> {{ trans('line.coord_y') }} </th><td> {{ $line->coord_y }} </td></tr><tr><th> {{ trans('line.angle') }} </th><td> {{ $line->angle }} </td></tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">
                        <a href="{{ url('line/' . $line->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit Line"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['line', $line->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"/>', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Line',
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