@extends('layouts.app')

@section('content')
<div class="container">
    <p><a href="{{ url('/') }}">Home</a>&nbsp>&nbsp<a href="{{ url(Auth::id() . '/project/') }}"> Projects</a>&nbsp&nbsp> Experiences</p>

    <h1>Experience <a href="{{ url(Auth::id() . '/project/' .  $id_project . '/experience/create') }}" class="btn btn-primary btn-xs" title="Add New Experience"><span class="glyphicon glyphicon-plus" aria-hidden="true"/></a></h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th><th> {{ trans('experience.name') }} </th><th> {{ trans('experience.image_link') }} </th><th>Image</th></th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @foreach($experience as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td>{{ $item->name }}</td><td><a href="{{ $item->image_link }}">{{ $item->image_link }}</td>
                    <td>
                        @if($item->image_link != "" )
                            <a href="{{ $item->image_link }}"><img  height="50" width="80" src="{{$item->image_link}}" ></img></a>
                        @endif
                    </td>
                    <td>
                        <a href="{{ url(Auth::id() . '/project/' . $item->id_project . '/experience/' . $item->id . '/show/') }}" class="btn btn-success btn-xs" title="View Experience"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"/></a>
                        <a href="{{ url(Auth::id() . '/project/' . $item->id_project . '/experience/' . $item->id . '/edit/') }}" class="btn btn-primary btn-xs" title="Edit Experience"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a> 
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['/experience', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                        {!! Form::hidden('id_project', $item->id_project) !!}
                        {!! Form::hidden('id_user', Auth::id()) !!}
                            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete Experience" />', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Experience',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ));!!}
                        {!! Form::close() !!}
                         &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                        <a href="{{ url(Auth::id() . '/project/' . $item->id_project . '/experience/' .$item->id . '/material') }}" class="btn btn-primary btn-xs" title="List materials">List Materials</a>
                        <a href="{{ url(Auth::id() . '/project/' . $item->id_project . '/experience/' .$item->id . '/upload') }}" class="btn btn-success btn-xs" title="upload image"><span class="glyphicon glyphicon-upload" aria-hidden="true"/> UPLOAD</a>
                        @if($item->n_graos > 0 )
                        <a href="{{ url(Auth::id() . '/project/' . $item->id_project . '/experience/' .$item->id . '/experience_information') }}" class="btn btn-danger btn-xs" title="information"><span class="glyphicon glyphicon-stats" aria-hidden="true"/> Data Analysis</a>
                        <!-- <a href="{{ url(Auth::id() . '/project/' . $item->id_project . '/experience/' .$item->id . '/getworkspace') }}" class="btn btn-success btn-xs" title="upload image"><span class="glyphicon glyphicon-upload" aria-hidden="true"/> workspace</a>-->
                        @endif
                        </br></br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                        @if($item->scale_px > 0 && $item->scale_real > 0 && $item->width_workspace > 0 && $item->heigth_workspace > 0 && $item->tem_material > 0)
                        <a href="{{ url(Auth::id() . '/project/' . $item->id_project . '/experience/' .$item->id . '/workspace') }}" class="btn btn-primary btn" title="workspace"><span class="glyphicon glyphicon-wrench" aria-hidden="true"/> WORKSPACE</a>
                        @endif
                        
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $experience->render() !!} </div>
    </div>

</div>
@endsection
