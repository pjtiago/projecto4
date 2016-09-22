@extends('layouts.app')

@section('content')
<div class="container">
    <p><a href="{{ url('/') }}">Home</a>&nbsp>&nbsp<a href="{{ url(Auth::id() . '/project/') }}"> Projects</a>&nbsp>&nbsp<a href="{{ url(Auth::id() . '/project/'. $id_project . '/experience') }}"> Experiences</a>&nbsp>&nbsp<a href="{{ url(Auth::id() . '/project/'. $id_experience. '/experience/material') }}"></a><a href="{{ url(Auth::id() . '/project/'. $id_project. '/experience/' . $id_experience . '/material/') }}"> Phases</a>&nbsp> Edit Phase</p>

    <h1>Edit Phase </h1>

    {!! Form::model($material, [
        'method' => 'PATCH',
        'url' => ['/material', $material->id],
        'class' => 'form-horizontal'
    ]) !!}

                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                {!! Form::label('name', trans('material.name'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
    {!! Form::hidden('id_project', $id_project) !!}
    {!! Form::hidden('id_experience', $material->id_experience) !!}
    {!! Form::hidden('id_user', Auth::id()) !!}
    

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

</div>
@endsection