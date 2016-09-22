@extends('layouts.app2')

@section('content')

<div class="container">
    <div id="linkajuda" class="col-md-10">
        
    <a href="{{ url('/') }}">Home</a>&nbsp>&nbsp<a href="{{ url(Auth::id() . '/project/') }}"> Projects</a>&nbsp>&nbsp<a href="{{ url(Auth::id() . '/project/'. $experience->id_project . '/experience') }}"> Experiences</a>&nbsp> Get Scale
    <button id="ajuda" type="button" class="btn btn-xs pull-right inline btn-default glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="left" title="
    Click two times on the image scale, to set the pixels scale, and fill the corresponding size in microns in the form field.">
            </button>
            </div>
    <div class="row">
        <div class="col-md-12">
            <div id="erros">
                
            </div>
            
            
            <div style="position: relative;">
                {!! Form::model($experience, [
                    'method' => 'PATCH',
                    'url' => ['/experience', $experience->id],
                    'class' => 'form-horizontal'
                ]) !!}
                <div class="form-group  {{ $errors->has('scale_real') ? 'has-error' : ''}}">
                    {!! Form::label('scale_real', trans('Scale Microns'), ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-2">
                        {!! Form::text('scale_real', null, ['class' => 'form-control']) !!}
                        {!! $errors->first('scale_real', '<p class="help-block">:message</p>') !!}
                    </div>
                    {!! Form::label('scale_px', trans('Scale Pixels'), ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-2">
                        {!! Form::number('scale_px', null, ['id'=>'campoPx', 'class' => 'form-control']) !!}
                        {!! $errors->first('scale_px', '<p class="help-block">:message</p>') !!}
                    </div>
                    {!! Form::hidden('name', $experience->name) !!}
                    {!! Form::hidden('id_project', $experience->id_project) !!}
                    {!! Form::hidden('id_user', Auth::id()) !!}
                    
                    <div class=" col-sm-2">
                        {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
                    </div>
                </div>
                {!! Form::close() !!}

                </div>
                <div style="position: relative;">
                	<canvas id="myCanvasFoto" width="800" height="400" style="position: absolute; left: 0; top: 0; z-index: 0; border:1px solid #d3d3d3;">
                	Your browser does not support the HTML5 canvas tag.</canvas>
                	<canvas id="myCanvasLateral" width="5" height="400" style="visibility:hidden; margin-left: 810px ; border:1px solid #d3d3d3;">
                	Your browser does not support the HTML5 canvas tag.</canvas>
                
                	<canvas id="myCanvasInferior" width="800" height="6" style="visibility:hidden; margin-top: 5px; border:1px solid #d3d3d3;">
                	Your browser does not support the HTML5 canvas tag.</canvas>
                </div>
                
          
    </div>
</div>
            
<script>
    /************************************************************
    script para gravar valores da escala da experiencia
    ************************************************************/
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });
    $('#ajuda').css("cursor", "default");

    $("#campoPx").prop("readonly", true);
    var cFoto = document.getElementById("myCanvasFoto");
    var cLateral = document.getElementById("myCanvasLateral");
    var cInferior = document.getElementById("myCanvasInferior");
    
    var ctxFoto = cFoto.getContext("2d");
    var ctxLateral = cLateral.getContext("2d");
    var ctxInferior = cInferior.getContext("2d");
    var img = new Image();
    var x_max = cFoto.width;
    var y_max = cFoto.height;
    var experience = <?php echo json_encode ($experience); ?>;
   
    img.src = experience.image_link;
    var foto_width = experience.width;
    var foto_height =  experience.heigth;
    cFoto.width= foto_width;
    cFoto.height= foto_height;
    cLateral.height = foto_height;
    cInferior.width = foto_width;
    
    var x_inicio_escala = 0; var y_inicio_escala = 0; var x_fim_escala = 0; var y_fim_escala = 0;
    var escala_px = 0;
    
    cFoto.addEventListener('click', on_canvas_click, false);
    function on_canvas_click(ev) {
        var rect = cFoto.getBoundingClientRect();
        var x = ev.clientX - rect.left;
        var y = ev.clientY - rect.top;
        if(x_inicio_escala == 0 && y_inicio_escala == 0){
            x_inicio_escala = x; y_inicio_escala = y;
        }else{
            if(x_fim_escala == 0 && y_fim_escala== 0){
                x_fim_escala = x; y_fim_escala = y;
                var temp_distancia_x  = (x_inicio_escala - x_fim_escala) * (x_inicio_escala - x_fim_escala);
                
                var temp_distancia_y = (y_inicio_escala - y_fim_escala) * (y_inicio_escala - y_fim_escala);
                escala_px = Math.floor(Math.sqrt(temp_distancia_x + temp_distancia_y));
                $('#campoPx').val(escala_px);
                
                bootbox.confirm("Do you wish to have this Pixels Scale: " +escala_px+"px", function(result) {
                    if(result == true){
                        $('#erros').empty();
                        $('#erros').append('<div class="alert alert-success">'+
              '<strong>Scale Saved!!</strong></div>');
                    }else{
                        x_inicio_escala = 0; y_inicio_escala = 0;
                        x_fim_escala = 0; y_fim_escala =0;
                        $('#campoPx').val(0);
                    }
                });
            }else{
                $('#erros').empty();
                $('#erros').append('<div class="alert alert-warning">'+
              '<strong>You already have the Scale!!</strong></div>');
            }
        }
    }
    img.onload = function() {
     ctxFoto.drawImage(img, 0, 0);
    };
</script>         
@endsection
