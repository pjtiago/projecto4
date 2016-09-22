@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Line <a href="{{ url('/line/create') }}" class="btn btn-primary btn-xs" title="Add New Line"><span class="glyphicon glyphicon-plus" aria-hidden="true"/></a></h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th><th> {{ trans('line.coord_x') }} </th><th> {{ trans('line.coord_y') }} </th><th> {{ trans('line.angle') }} </th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @foreach($line as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td>{{ $item->coord_x }}</td><td>{{ $item->coord_y }}</td><td>{{ $item->angle }}</td>
                    <td>
                        <a href="{{ url('/line/' . $item->id) }}" class="btn btn-success btn-xs" title="View Line"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"/></a>
                        <a href="{{ url('/line/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit Line"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['/line', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete Line" />', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Line',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ));!!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $line->render() !!} </div>
    </div>

</div>
@endsection
