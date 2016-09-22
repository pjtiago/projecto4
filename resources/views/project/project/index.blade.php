@extends('layouts.app')

@section('content')
<div class="container">
    <p><a href="{{ url('/') }}">Home</a>&nbsp> Projects</p>
    <h1>Project <a href="{{ url(Auth::id() . '/project/create') }}" class="btn btn-primary btn-xs" title="Add New Project"><span class="glyphicon glyphicon-plus" aria-hidden="true"/></a></h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th><th> {{ trans('project.name') }} </th><th> {{ trans('project.description') }} </th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @foreach($project as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td>{{ $item->name }}</td><td>{{ $item->description }}</td>
                    <td>
                        <a href="{{ url(Auth::id() . '/project/' . $item->id . '/show') }}" class="btn btn-success btn-xs" title="View Project"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"/></a>
                        <a href="{{ url(Auth::id() . '/project/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit Project"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['/project', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
              
                            {!! Form::hidden('id_user', Auth::id()) !!}
        
                            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete Project" />', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Project',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ));!!}
                        {!! Form::close() !!}
                        &nbsp&nbsp&nbsp
                        <a href="{{ url(Auth::id() . '/project/' . $item->id . '/experience') }}" class="btn btn-primary btn-xs" title="List Experiences">List Experience</a>
                        <a href="{{ url( Auth::id() . '/project/' . $item->id . '/experience/create') }}" class="btn btn-success btn-xs" title="Create Experience">Create Experience</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $project->render() !!} </div>
    </div>

</div>
@endsection
