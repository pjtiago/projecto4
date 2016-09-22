@extends('layouts.app')

@section('content')
<div class="container">
    <p><a href="{{ url('/') }}">Home</a>&nbsp>&nbsp<a href="{{ url(Auth::id() . '/project/') }}"> Projects</a>&nbsp>&nbsp<a href="{{ url(Auth::id() . '/project/'. $id_project . '/experience') }}"> Experiences</a><a href="{{ url(Auth::id() . '/project/'. $id_experience . '/experience') }}"></a>&nbsp> Phases</p>
    <h1>Phase <a href="{{ url(Auth::id() . '/project/' .  $id_project . '/experience/' . $id_experience . '/material/create') }}" class="btn btn-primary btn-xs" title="Add New Material"><span class="glyphicon glyphicon-plus" aria-hidden="true"/></a></h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th><th> {{ trans('material.name') }} </th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @foreach($material as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td>{{ $item->name }}</td>
                    <td>
                        <a href="{{ url(Auth::id() . '/project/' . $id_project . '/experience/' . $item->id_experience . '/material/' . $item->id . '/edit/' ) }}" class="btn btn-primary btn-xs" title="Edit Material"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['/material', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                        {!! Form::hidden('id_project', $id_project) !!}
                        {!! Form::hidden('id_experience', $item->id_experience) !!}
                        {!! Form::hidden('id_user', Auth::id()) !!}
                        
                            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete Material" />', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Material',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ));!!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $material->render() !!} </div>
    </div>

</div>
@endsection
