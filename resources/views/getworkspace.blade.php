@extends('layouts.app2')

@section('content')

<div class="container">
    <div id="linkajuda" class="col-md-10">
        
<a href="{{ url('/') }}">Home</a>&nbsp>&nbsp<a href="{{ url(Auth::id() . '/project/') }}"> Projects</a>&nbsp>&nbsp<a href="{{ url(Auth::id() . '/project/'. $experience->id_project . '/experience') }}"> Experiences</a>&nbsp> Get Workspace
    <button  id="ajuda2" type="button" class="btn btn-xs pull-right inline btn-default glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="left" title="
    Click two times on the image to set your Working Stage.">
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
                <div class="form-group {{ $errors->has('width_workspace') ? 'has-error' : ''}}">
                    {!! Form::label('width_workspace', trans('Width'), ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-2">
                        {!! Form::number('width_workspace', null, ['id'=>'work_width','class' => 'form-control']) !!}
                        {!! $errors->first('width_workspace', '<p class="help-block">:message</p>') !!}
                    </div>
                    {!! Form::label('heigth_workspace', trans('Heigth'), ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-2">
                        {!! Form::number('heigth_workspace', null, ['id'=>'work_heigth','class' => 'form-control']) !!}
                        {!! $errors->first('heigth_workspace', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('coord_x_workspace') ? 'has-error' : ''}}">
                    {!! Form::label('coord_x_workspace', trans('Coord X Start Point'), ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-2">
                        {!! Form::number('coord_x_workspace', null, ['id'=>'coordX','class' => 'form-control']) !!}
                        {!! $errors->first('coord_x_workspace', '<p class="help-block">:message</p>') !!}
                    </div>
                    {!! Form::label('coord_y_workspace', trans('Coord Y Start Point'), ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-2">
                        {!! Form::number('coord_y_workspace', null, ['id'=>'coordY','class' => 'form-control']) !!}
                        {!! $errors->first('coord_y_workspace', '<p class="help-block">:message</p>') !!}
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
                	<canvas id="myCanvas" width="800" height="400" style="position: absolute; left: 0; top: 0; z-index: 1; border:1px solid #d3d3d3;">
                	Your browser does not support the HTML5 canvas tag.</canvas>
                	<canvas id="myCanvasLateral" width="5" height="400" style="visibility:hidden; margin-left: 810px ; border:1px solid #d3d3d3;">
                	Your browser does not support the HTML5 canvas tag.</canvas>
                
                	<canvas id="myCanvasInferior" width="800" height="6" style="visibility:hidden; margin-top: 5px; border:1px solid #d3d3d3;">
                	Your browser does not support the HTML5 canvas tag.</canvas>
                </div>
                
          
    </div>
</div>
            
<script>
    /********************************************************
    script para gravar valores do "Workspace" da experiencia
    ********************************************************/
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });
    $('#ajuda2').css("cursor", "default");

    $("#coordX").prop("readonly", true);
    $("#coordY").prop("readonly", true);
    $("#work_heigth").prop("readonly", true);
    $("#work_width").prop("readonly", true);
    
    var cFoto = document.getElementById("myCanvasFoto");
    var c = document.getElementById("myCanvas");
    var cLateral = document.getElementById("myCanvasLateral");
    var cInferior = document.getElementById("myCanvasInferior");
    
    var ctxFoto = cFoto.getContext("2d");
    var ctx = c.getContext("2d");
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
    c.height = foto_height;
    c.width = foto_width;
    
    var x_inicio = 0; var y_inicio = 0; var x_fim = 0; var y_fim = 0;
    var escala_px = 0;
    var size_x = 0;
    var size_y=0;
    var x = 0;
    var y = 0;
                        
    c.addEventListener('click', on_canvas_click, false);
    function on_canvas_click(ev) {
      
        var rect = cFoto.getBoundingClientRect();
        var x = ev.clientX - rect.left;
        var y = ev.clientY - rect.top;
        
        if(x_inicio == 0 && y_inicio == 0){
            x_inicio = x; y_inicio = y;
        }else{
            if(x_fim == 0 && y_fim== 0){
                x_fim = x; y_fim = y;

                if(x_fim >= x_inicio){
                    x = x_inicio;
                    size_x = x_fim - x_inicio ;
                }else{
                    x = x_fim;
                    size_x = x_inicio - x_fim;
                }
                
                if(y_fim >= y_inicio){
                    y = y_inicio;
                    size_y = y_fim - y_inicio;
                }else{
                    y = y_fim;
                    size_y = y_inicio - y_fim;
                }
                ctx.beginPath();  // path commands must begin with beginPath
                ctx.fillStyle= "rgba(0, 0, 0, 0.2)";
                ctx.rect(x,y,size_x,size_y); 
                ctx.fill();
                 bootbox.confirm("Do you wish to have this Workspace?", function(result) {
                     if(result == true){
                        $('#erros').empty();
                        $('#erros').append('<div class="alert alert-success">'+
              '<strong>Workspace Saved!!</strong></div>');
                        $('#coordX').val(Math.floor(x));
                        $('#coordY').val(Math.floor(y));
                        $('#work_heigth').val(size_y);
                        $('#work_width').val(size_x);
                     }else{
                        $('#erros').empty();
                        $('#erros').append('<div class="alert alert-danger">'+
                      '<strong>You didnt save the Workspace!!</strong></div>');
                        $('#coordX').val(0);
                        $('#coordY').val(0);
                        $('#work_heigth').val(0);
                        $('#work_width').val(0);
                        ctx.clearRect(x,y,size_x,size_y);
                        x_inicio = 0; y_inicio = 0;
                        x_fim = 0; y_fim = 0;
                        x = 0;
                        y = 0;
                     }
                 });
            }
        }
    }
       
img.onload = function() {
 ctxFoto.drawImage(img, 0, 0);
};
</script>         
@endsection