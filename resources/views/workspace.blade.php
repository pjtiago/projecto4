@extends('layouts.app2')

@section('content')

<div  class="container" style="margin-left: 50px;">
    <div id="linkajuda" class="col-md-10">
        
    <a href="{{ url('/') }}">Home</a>&nbsp>&nbsp<a href="{{ url(Auth::id() . '/project/') }}"> Projects</a>&nbsp>&nbsp<a href="{{ url(Auth::id() . '/project/'. $experience->id_project . '/experience') }}"> Experiences</a>&nbsp> Workspace
    <button id="ajuda3" type="button" class="btn btn-xs pull-right inline btn-default glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="left" title="
    Click on 'Get Line' to generate a random line, then press on the grain borders,
    after that press on 'Save Line' to store the information.">
            </button>
            </div>

    <div class="row">
        <div class="col-md-12 col-md-offset-6">
          

        </div>
        <div class="col-md-12">

            <ul id="listaMateriais">
               
            </ul>
            <div style="position: relative;">
                	<button class="btn btn-primary" id="getLine">Get Line</button>
                	<button class="btn btn-success" id="saveLine" style="visibility:hidden">Save Line</button>
                	<label>Change Color: &nbsp</label>
                	<button class="btn btn-xs" id="getColorBlack" style="font-size:5px;background-color:black"> &nbsp</button>
                	<button class="btn btn-xs" id="getColorRed" style="font-size:5px;background-color:red"> &nbsp</button>
                	<button class="btn btn-xs" id="getColorGold" style="font-size:5px;background-color:gold"> &nbsp</button>
                	<button class="btn btn-xs" id="getColorBlue" style="font-size:5px;background-color:blue"> &nbsp</button>
            </div>
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-11">
            <div style="position: relative;">
            	<canvas id="myCanvasFoto" width="800" height="400" style="position: absolute; left: 0; top: 0; z-index: 0; border:1px solid #d3d3d3;">
            	Your browser does not support the HTML5 canvas tag.</canvas>
            	<canvas id="myCanvas" width="800" height="400" style="position: absolute; left: 0; top: 0; z-index: 1; border:1px solid #d3d3d3;">
            	Your browser does not support the HTML5 canvas tag.</canvas>
            	<canvas id="myCanvasLateral" width="10" height="400" style="visibility:hidden; margin-left: 810px ; border:1px solid #d3d3d3;">
            	Your browser does not support the HTML5 canvas tag.</canvas>
            
            	<canvas id="myCanvasInferior" width="800" height="10" style="visibility:hidden; margin-top: 5px; border:1px solid #d3d3d3;">
            	Your browser does not support the HTML5 canvas tag.</canvas>
            </div>
        </div>
        <div class="col-md-1">
            <div>Contrast
            </div>
            <input class="btn btn-primary btn-xs" id="clickMe" type="button" value="+" onclick="adjustPlus();" />
            <input class="btn btn-primary btn-xs" id="clickMe2" type="button" value="-" onclick="adjustLess();" />
        </div>
        <div class="col-md-1">
            
            <div id="curve_chart" style=" width: 500px; height: 500px"></div>
            <a href="{{ url(Auth::id() . '/project/' . $experience->id_project . '/experience/' .$experience->id . '/experience_information') }}" id="botao_analise" class="btn btn-danger btn" title="information" style="visibility: hidden;"><span class="glyphicon glyphicon-stats" aria-hidden="true"/> Data Analysis</a>

        </div>
    </div>
    <div class="row">
        <div id="listamateriais" class="col-md-12">
             
        </div>
    </div>
        
</div>
    
            
<script>
    
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });
    $('#ajuda3').css("cursor", "default");
    
    var experience = <?php echo json_encode ($experience); ?>;
    var material = <?php echo json_encode ($material); ?>;
    var linhas = <?php echo json_encode ($linhas); ?>;
    
    var mat_string = "";

    for (var i = 0;  i <= material.data.length - 1; i++) {
		mat_string = mat_string + "<option value=" + material.data[i].id + ">" + material.data[i].name + "</option>";
	}

    var array_info = [];
    var n_pontos = 0;
    var comp_total_linhas = 0;
    
    // array para guardar informação para o grafico
    array_info[0] = ['Number Of Lines','Grains Per Meter']; //Legenda do grafico
	array_info[1]=[0,0];
    for (var i = 0;  i <= linhas.length - 1; i++) {
		array_info[i+1] = [(i+1),(1000000*(linhas[i].n_graos_existentes / linhas[i].comprimento_linhas_existentes))];
		n_pontos = linhas[i].n_graos_existentes;
		comp_total_linhas = linhas[i].comprimento_linhas_existentes;
	}
	
    // Colaca botao de analise visivel qd já existe linhas adicionadas
	if(linhas.length >= 1){
	    $('#botao_analise').css('visibility', 'visible');
	}else{
	    array_info[1]=[0,0];
	}
    var x=0;
    var y=0;
    var rectaExiste = false;
    var primeiro_ponto =  false; 
    var marcador_x;
    var marcador_y;
   
    var c = document.getElementById("myCanvas");
    var cFoto = document.getElementById("myCanvasFoto");
    var cLateral = document.getElementById("myCanvasLateral");
    var cInferior = document.getElementById("myCanvasInferior");
    
    var ctx = c.getContext("2d");
    var ctxFoto = cFoto.getContext("2d");
    var ctxLateral = cLateral.getContext("2d");
    var ctxInferior = cInferior.getContext("2d");
    
    var img = new Image();
    
    
    var x_max = c.width;
    var y_max = c.height;
    var xi;
    var yi;
    var xf;
    var yf;
    var m;
    var b;
    var angulo;
    
    var foto_width = experience.width;
    var foto_height =  experience.heigth;
    
 
    var pontos = new Array();
    
    var Ponto = function (x,y) {
      this.x = x;
      this.y = y;
    };
    
    var segmentos = new Array();
    //Objecto segmento para inserção na bd
    var Segmento = function (comprimento,material) {
      this.comprimento = comprimento;
      this.material = material;
    };
    var numero_clicks;
    var comprimento_total_linha;
    
    //Escohla de cores da linha e pontos
    var color = '#000';
    var color_markers = "#fff";
    
    $( "#getColorBlack" ).click(function() {
        color = '#000';
        color_markers = '#fff';
    });
    
    $( "#getColorRed" ).click(function() {
        color = '#f00';
        color_markers = 'white';
    });
    
    $( "#getColorGold" ).click(function() {
        color = 'gold';
        color_markers = 'silver';
    });
    
    $( "#getColorBlue" ).click(function() {
        color = 'blue';
        color_markers = 'orange';
    });
    
    //Funçao de click para gerar uma linha
    $( "#getLine" ).click(function() {
        $('#listamateriais').empty();
        comprimento_total_linha = 0;
        gerarRecta();// Contas para gerar a linha
        //comprimento_total_linha = Math.sqrt(Math.pow(xi - xf,2) + Math.pow(yi - yf,2));
        pontos = [];
        segmentos = [];
        numero_clicks = 0;
        primeiro_ponto = false;
        $('#saveLine').css("visibility","visible");
        $('#listamateriais').append('<select id="select_material_0" class="btn btn-primary selectpicker">' + mat_string + '</select> ');
    });
    
    //Funçao de click para guardar uma uma linha
      $( "#saveLine" ).click(function() {
        //Condiçao caso não haja clicks de criar nova linha.
        if(segmentos.length == 0){
            comprimento_total_linha = 0;
            gerarRecta();
            //comprimento_total_linha = Math.sqrt(Math.pow(xi - xf,2) + Math.pow(yi - yf,2));
            pontos = [];
            segmentos = [];
            numero_clicks = 0;
            primeiro_ponto = false;
            $('#saveLine').css("visibility","visible");
            $('#listamateriais').empty();
        }else{
            if(primeiro_ponto){
                pontos.push(new Ponto(xf,yf));
            }else{
                pontos.push(new Ponto(xi,yi));
            }
            // inserir ultimo segmento
            dist_segmento = 2 * Math.sqrt(Math.pow((pontos[pontos.length - 1].x - pontos[pontos.length - 2].x),2) + (Math.pow((pontos[pontos.length - 1].y - pontos[pontos.length - 2].y),2)));
            segmentos.push(new Segmento(dist_segmento,material.data[0].id));
            
            for (var i = 0;  i < segmentos.length; i++) {
        		segmentos[i].material = parseInt(($('#select_material_' + (i)).val()),0);
        		comprimento_total_linha += segmentos[i].comprimento;
        	}
        	
            comp_total_linhas = comp_total_linhas + comprimento_total_linha;
              
            insereLinha(experience.id,x,y,angulo,pontos,segmentos, comprimento_total_linha, numero_clicks);
            
            $('#saveLine').css("visibility","hidden");
            ctx.clearRect(0, 0, c.width, c.height);
            rectaExiste = false;
            
            var comp_array = array_info.length;
            n_pontos += numero_clicks;
            
            if(array_info[1][0] == 0 ){
                 array_info[1] = [(1),(1000000*(n_pontos/(comp_total_linhas)))];
            }else{
                array_info[comp_array] = [(comp_array),(1000000*(n_pontos / (comp_total_linhas)))];
            }
            
            $('#botao_analise').css('visibility', 'visible');

            xi=0;yi=0;xf=0;yf=0;m=0;b=0;angulo=0;
            pontos = [];
            segmentos = [];
            primeiro_ponto = false;
            $('#listamateriais').empty();
            
           drawChart();
        }
    });
    
        /**
         * função para com pedido ajax para enviar informação para
         * controlador para este validar e inserir a a informação na
         * base de dados
         * 
         **/
        function insereLinha(id_experience,coord_x,coord_y,angle,pontos,segmentos, comprimento_total_linha, numero_clicks) {
            $.ajax({
                type: "POST",
                url: '/storeline',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'id_experience': id_experience,
                    'coord_x':Math.floor(coord_x),
                    'coord_y':Math.floor(coord_y),
                    'angle':angle,
                    'arr_pontos':pontos,
                    'arr_segments': segmentos,
                    'comprimento_total_linha':comprimento_total_linha,
                    'numero_clicks':numero_clicks
                },
                success: function(data) {
                    //console.log(data);
                }
            })
        };
    
    img.src = experience.image_link;
    
    
    cFoto.width= foto_width;
    cFoto.height= foto_height;
    c.width= experience.width_workspace;
    c.height= experience.heigth_workspace;
    c.style.top = experience.coord_y_workspace + "px";
    c.style.left = experience.coord_x_workspace + "px";
    
    cLateral.height = foto_height;
    cInferior.width = foto_width;
    // Função que retorna a posiçao do rato
    function getMousePos(c, evt) {
        var rect = c.getBoundingClientRect();
        return {
          x: evt.clientX - rect.left,
          y: evt.clientY - rect.top
        };
    }
    /**
     * função usada para mover marcador em cima da linha gerada
     * que marca a zona de onde o ponto sera marcado com o click
     * 
    **/
    c.addEventListener('mousemove', function(evt) {
        if(rectaExiste){
            var mousePos = getMousePos(c, evt);
            var message = 'Mouse position: ' + mousePos.x + ',' + mousePos.y;

            if ((angulo>=0 && angulo<=(0.25 * Math.PI))||(angulo>=(0.75 * Math.PI) && angulo<=(1.25 * Math.PI))||(angulo>=(1.75 * Math.PI) && angulo<=2 * Math.PI)) {
            	marcador_x = mousePos.x;
            	marcador_y = m * marcador_x +b;
            } else {
            	marcador_y = mousePos.y;
            	marcador_x = (marcador_y - b) / m;
            }
            
            ctx.clearRect(0,0,x_max,y_max);
            
            ctx.beginPath();
    		ctx.moveTo(xi,yi);
    		ctx.lineTo(xf,yf);
    		ctx.stroke();
    		ctx.closePath();
            
            ctx.beginPath();
            
    		ctx.arc(marcador_x,marcador_y,3,0,2*Math.PI);
    		ctx.strokeStyle = color;
          	ctx.stroke();
            ctx.closePath();
    
    		if(pontos.length > 0){
    		    for(i=0;i<pontos.length;i++){
    		        ctx.beginPath();
                    ctx.arc(pontos[i].x, pontos[i].y, 5, 0, 2*Math.PI);
                    ctx.strokeStyle = color;
                    ctx.stroke();
                    ctx.fillStyle = color_markers;
                    ctx.fill();
                    ctx.closePath();
    		    }
    		   
    		}
        }
    }, false); 
    
    
    /**
     * função para chamada com click com guarda pronto do click e o guarda num
     * array para depois sere inserido na basa de dados
     * 
    **/
    $(c).click(function(){
      if(!isNaN(marcador_x) && !isNaN(marcador_y)){
          var primeiro_segmento = false;
          var dist_segmento = 0;
        if(pontos.length == 0){
            var distancia_inicio = Math.sqrt(Math.pow((marcador_x - xi),2) + (Math.pow((marcador_y-yi),2)));
            var distancia_final = Math.sqrt(Math.pow((marcador_x - xf),2) + (Math.pow((marcador_y-yf),2)));
            primeiro_segmento = true;
            if(distancia_inicio < distancia_final){
                pontos.push(new Ponto(xi,yi));
                primeiro_ponto = true;
            }else{
                pontos.push(new Ponto(xf,yf));
                primeiro_ponto = false;
            }
        }
        pontos.push(new Ponto(marcador_x,marcador_y));
        if(primeiro_segmento){
                dist_segmento = 2 * Math.sqrt(Math.pow((pontos[pontos.length - 1].x - pontos[pontos.length - 2].x),2) + (Math.pow((pontos[pontos.length - 1].y - pontos[pontos.length - 2].y),2)));
            }else{
                dist_segmento = Math.sqrt(Math.pow((pontos[pontos.length - 1].x - pontos[pontos.length - 2].x),2) + (Math.pow((pontos[pontos.length - 1].y - pontos[pontos.length - 2].y),2)));
        }
        segmentos.push(new Segmento(dist_segmento,material.data[0].id));
        numero_clicks += 1;
        $('#listamateriais').append('<select id="select_material_'+(numero_clicks) +'" class="btn btn-primary selectpicker">' + mat_string + '</select> ');
      }
    });
    
    
    /**
     * função para chamada gerar recta alietoria para que possa ser 
     * feita a analise
     * 
    **/
    function gerarRecta() {
        rectaExiste = true;
    	
    	angulo = (Math.random() * ((Math.PI) * 2));
    	x_max = c.width;
    	y_max = c.height;
    
    	ctx.beginPath();
    	ctx.clearRect(0,0,x_max,y_max);
    	
    	x = Math.floor((Math.random() * (x_max + 1)));
    	y = Math.floor((Math.random() * (y_max + 1)));
    	m = Math.tan(angulo);
    	
    	b = (-m) * x + y;
    	
    	if ( (angulo >=0 && angulo <= 0.001) || ((angulo >= (Math.PI)- 0.001) && angulo <= ((Math.PI) + 0.001)) || (angulo >=( 2*(Math.PI) - 0.001) && angulo <= ( 2*(Math.PI) + 0.001))) {
    	
    		xi = 0;
    		yi = y;
    		xf = x_max;
    		yf= y;
    		
    	}else {
    		if (angulo == (0.5 * Math.PI) || angulo == (1.5 * Math.PI)) {
    			xi = x;
    		    yi = 0;
    		    xf = x;
    		    yf= y_max;
    		} else {
    			var x1 = 0;
    			var y1 = m * x1 + b;
    
    			var y2 = 0;
    			var x2 = (y2 - b) / m;
    			
    			var x3 = x_max;
    			var y3 = m * x3 + b;
    
    			var y4 = y_max;
    			var x4 = (y4 - b) / m;
    			
    			if ((y1 >= 0 && y1<=y_max) && (x2 >= 0 && x2 <= x_max)) {
    				xi = x1;
    				yi = y1;
    				xf = x2;
    				yf = y2;
    			} else {
    				if ((x4 >= 0 && x4 <= x_max) && (x2 >= 0 && x2 <= x_max)){
    					xi = x4;
    					yi = y4;
    					xf = x2;
    					yf = y2;
    				}else {
    					if ((x4 >= 0 && x4 <= x_max) && (y3 >= 0 && y3 <= y_max)){
    						xi = x4;
    						yi = y4;
    						xf = x3;
    						yf = y3;
    					}else{
    						if ((y1 >= 0 && y1<=y_max) && (x4 >= 0 && x4 <= x_max)){
    						xi = x1;
    						yi = y1;
    						xf = x4;
    						yf = y4;
    						}else{
    							if ((x2 >= 0 && x2 <= x_max) && (x4 >= 0 && x4 <= x_max)) {
    								xi = x2;
    								yi = y2;
    								xf = x4;
    								yf = y4;
    							} else {
    							    if ((y1 >= 0 && y1<=y_max) && (y3 >= 0 && y3 <= y_max )){
    							        xi = x1;
        								yi = y1;
        								xf = x3;
        								yf = y3;
    							    } else {
        								xi = x2;
        								yi = y2;
        								xf = x3;
        								yf = y3;
    							    }
    							}
    						}
    					}
    				}
    			}
    		}
    	}
    	ctx.lineWidth=2;
    	ctx.strokeStyle = color;
    	ctx.moveTo(xf,yf);
    	ctx.lineTo(xi,yi);
    	ctx.stroke();
    }
    
    img.onload = function() {
        ctxFoto.drawImage(img, 0, 0);
    };
    
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    
    /**
     * função para desenhar grafico
     * 
    **/
    function drawChart() {
        var data = google.visualization.arrayToDataTable(array_info);
        var options = {
          title: 'Average grains number per meter',
          curveType: 'function',
            hAxis: {
              title: 'Number of Lines'
            },
            vAxis: {
              title: 'Points per Meter'
            },
          legend: { position: 'none' }
        };
        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
        chart.draw(data, options);
    }
    var op=0;
    function adjustPlus(){
       
        op +=0.1;
        ctx.beginPath();  // path commands must begin with beginPath
        ctxFoto.fillStyle= "rgba(0, 0, 0,"+op+")";
        ctxFoto.rect(0,0,img.width,img.height); 
        ctxFoto.fill();
        
    }
    function adjustLess(){
        op = 0 
        ctxFoto.clearRect(0, 0, img.width, img.height);
        ctxFoto.drawImage(img, 0, 0);
    }
    </script>
@endsection
