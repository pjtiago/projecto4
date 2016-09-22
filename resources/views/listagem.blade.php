@extends('layouts.app')

@section('content')
<div class="container">
    <p><a href="{{ url('/') }}">Home</a> > Administration</p>
    <h1>User</h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th><th> Name </th><th>Email</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @foreach($user as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['/users', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                        
                            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete User" />', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete User',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ));!!}
                        {!! Form::close() !!}
                        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                        Admin
                        &nbsp&nbsp&nbsp
                        {!! Form::open([
                            'method'=>'PATCH',
                            'url' => ['/users', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                            
                            @if ($item->level == 1)
                                {!! Form::checkbox('level', '1', true); !!}
                            @else
                                {!! Form::checkbox('level', '1'); !!}
                            @endif
                            
                            {!! Form::hidden('id_user', Auth::id()) !!}
                        
                            {!! Form::button('<span class="glyphicon glyphicon-upload" aria-hidden="true" title="Update User" />', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-success btn-xs',
                                    'title' => 'Update User',
                                    'onclick'=>'return confirm("Confirm Update?")'
                            ));!!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $user->render() !!} </div>
    </div>

</div>
@endsection
