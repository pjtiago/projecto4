@extends('layouts.app')

@section('content')
<div class="container">
    <p><a href="{{ url('/') }}">Home</a>&nbsp>&nbsp<a href="{{ url(Auth::id() . '/project/') }}"> Projects</a>&nbsp>&nbsp<a href="{{ url(Auth::id() . '/project/'. $experience->id_project . '/experience') }}"> Experiences</a>&nbsp>Upload</p>

    <h1>Upload Image to Experience : {{ $experience->name }}</h1>
    </br></br>
    
     {!! Form::open(array('url'=>'apply/upload','method'=>'POST', 'files'=>true)) !!}
     <div class="control-group">
     <div class="controls">
     {!! Form::file('image') !!}
	  <p class="errors">{!!$errors->first('image')!!}</p>
	 @if(Session::has('error'))
	<p class="errors">{!! Session::get('error') !!}</p>
	@endif
        </div>
        </div>
        <div id="success"> </div>
        
        {!! Form::hidden('id_project', $experience->id_project) !!}
        {!! Form::hidden('id_experience', $experience->id) !!}
        {!! Form::hidden('id_user', Auth::id()) !!}
        
      {!! Form::submit('Submit', array('class'=>'send-btn')) !!}
      
      {!! Form::close() !!}
      
</div>
@endsection
