@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Segment {{ $segment->id }}</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tbody>
                <tr>
                    <th>ID.</th><td>{{ $segment->id }}</td>
                </tr>
                
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">
                        <a href="{{ url('segment/' . $segment->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit Segment"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['segment', $segment->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"/>', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Segment',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ));!!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

</div>
@endsection