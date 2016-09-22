@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Create New Experience</h1>
    <hr/>

    {!! Form::open(['url' => '/experience', 'class' => 'form-horizontal']) !!}

                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                {!! Form::label('name', trans('experience.name'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
          <!-- <div class="form-group {{ $errors->has('image_link') ? 'has-error' : ''}}">
                {!! Form::label('image_link', trans('experience.image_link'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('image_link', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('image_link', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('width') ? 'has-error' : ''}}">
                {!! Form::label('width', trans('experience.width'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::number('width', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('width', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('heigth') ? 'has-error' : ''}}">
                {!! Form::label('heigth', trans('experience.heigth'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::number('heigth', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('heigth', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('scale_px') ? 'has-error' : ''}}">
                {!! Form::label('scale_px', trans('experience.scale_px'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::number('scale_px', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('scale_px', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('scale_real') ? 'has-error' : ''}}">
                {!! Form::label('scale_real', trans('experience.scale_real'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::number('scale_real', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('scale_real', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('width_workspace') ? 'has-error' : ''}}">
                {!! Form::label('width_workspace', trans('experience.width_workspace'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::number('width_workspace', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('width_workspace', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('heigth_workspace') ? 'has-error' : ''}}">
                {!! Form::label('heigth_workspace', trans('experience.heigth_workspace'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::number('heigth_workspace', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('heigth_workspace', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('coord_x_workspace') ? 'has-error' : ''}}">
                {!! Form::label('coord_x_workspace', trans('experience.coord_x_workspace'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::number('coord_x_workspace', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('coord_x_workspace', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('coord_y_workspace') ? 'has-error' : ''}}">
                {!! Form::label('coord_y_workspace', trans('experience.coord_y_workspace'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::number('coord_y_workspace', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('coord_y_workspace', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            -->
            <div class="form-group" >
            {!! Form::hidden('id_project', $data['id_project']) !!}
            {!! Form::hidden('id_user', Auth::id()) !!}
            </div>
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