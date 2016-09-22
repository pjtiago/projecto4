@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Point <a href="{{ url('/point/create') }}" class="btn btn-primary btn-xs" title="Add New Point"><span class="glyphicon glyphicon-plus" aria-hidden="true"/></a></h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th><th> {{ trans('point.coord_x') }} </th><th> {{ trans('point.coord_y') }} </th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @foreach($point as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td>{{ $item->coord_x }}</td><td>{{ $item->coord_y }}</td>
                    <td>
                        <a href="{{ url('/point/' . $item->id) }}" class="btn btn-success btn-xs" title="View Point"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"/></a>
                        <a href="{{ url('/point/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit Point"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['/point', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete Point" />', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Point',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ));!!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $point->render() !!} </div>
    </div>

</div>
@endsection
