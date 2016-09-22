@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Create New Line</h1>
    <hr/>

    {!! Form::open(['url' => '/line', 'class' => 'form-horizontal']) !!}

                <div class="form-group {{ $errors->has('coord_x') ? 'has-error' : ''}}">
                {!! Form::label('coord_x', trans('line.coord_x'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::number('coord_x', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('coord_x', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('coord_y') ? 'has-error' : ''}}">
                {!! Form::label('coord_y', trans('line.coord_y'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::number('coord_y', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('coord_y', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('angle') ? 'has-error' : ''}}">
                {!! Form::label('angle', trans('line.angle'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::number('angle', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('angle', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        {!! Form::hidden('id_experience', 16 )!!}

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
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