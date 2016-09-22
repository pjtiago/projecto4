@extends('layouts.app2')

@section('content')

<div  class="container" style="margin-left: 50px;">
    <p><a href="{{ url('/') }}">Home</a>&nbsp>&nbsp<a href="{{ url(Auth::id() . '/project/') }}"> Projects</a>&nbsp>&nbsp<a href="{{ url(Auth::id() . '/project/'. $experience->id_project . '/experience') }}"> Experiences</a>&nbsp> Experience Information</p>

    <div class="row">
        <div class="col-md-6">
            
        <a href="{{ url(Auth::id() . '/project/' . $experience->id_project . '/experience/' .$experience->id . '/getExcel') }}" class="btn btn-danger btn-lg" title="export"><span class="glyphicon glyphicon-stats" aria-hidden="true"/> Export to Excel</a>
        </br>
        </br>
            <div>
                <b>Project: </b> 
            </div>
            <table class="table">
                <tr>
                    <th>Name:&nbsp&nbsp</th> 
                    <th>{{ $project->name }}</th>
                </tr>
                <tr>
                    <th>Description:&nbsp&nbsp</th>
                    <th>{{ $project->description }}</th>
                </tr>
            </table>
            <div>
                  <b>Experience: </b>
            </div>
           <table class="table">
                <tr>
                    <th>Name:&nbsp&nbsp</th> 
                    <th>{{ $experience->name }}</th>
                </tr>
                <tr>
                    <th>Date:&nbsp&nbsp</th>
                    <th>{{ $experience->created_at }}</th>
                </tr>
            </table>
           
            
            <div>
                  <b>Information: </b>
            </div>
           <table class="table">
                <tr>
                    <th>Number of Lines:&nbsp&nbsp</th> 
                    <th>{{ $n_linhas }}</th>
                </tr>
                <tr>
                    <th>Number of Grains:&nbsp&nbsp</th>
                    <th>{{ $experience->n_graos}}</th>
                </tr>
                <tr>
                    <th>Number of Grains per Meter:&nbsp&nbsp</th>
                    <th>{{ $n_graos_metro}}</th>
                </tr>
                <tr>
                    <th>Average Grain Size :&nbsp&nbsp</th>
                    <th>{{ $tamanho_medio_grao}}&nbsp&microm </th>
                </tr>
            </table>
            
              <div>
                  <b>Phases: </b>
            </div>
            
            <table class="table">
              <tbody>
                 {{-- */$x=0;/* --}}
                @foreach($material as $item)
                {{-- */$x++;/* --}}
                    <tr>
                      <th scope="row">{{ $x }}</th>
                      <td>{{ $item->name }}</td>
                    </tr>
                @endforeach
              </tbody>
            </table>
            
        </div>
 
        <div class="col-md-2">
            <div id="curve_chart" style="width: 500px; height: 500px"></div>
        </div>
        <div class="col-md-12">
            <div id="chart_div" style="width: 900px; height: 500px;"></div>
        </div>
        <div id="graficos" class="col-md-12">
            
        </div>
        
    </div>
</div>
    <script>
        /********************************************************
        Script para processar informção recebida da base de dados 
        ********************************************************/
        var linhas = <?php echo json_encode ($linhas); ?>;
        var segmentos = <?php echo json_encode ($segmentos); ?>;
        var materiais = <?php echo json_encode ($material); ?>;

        var array_info = []; //informação para grafico 
        var array_info2 = []; //informação para grafico
        var array_info3 = []; //informação para grafico
        array_info[0] = ['NumberOfLines','GrainsPerMetre'];
        array_info2[0] = ['Phase','Size'];
        
        for (var i = 0;  i <= linhas.length - 1; i++) {
    				array_info[i+1] = [(i+1),(1000000*(linhas[i].n_graos_existentes / (linhas[i].comprimento_linhas_existentes)))];
    	}
    	
    	var contador = 1;
    	var contador2;
    	for (var i = 0;  i <= materiais.length  - 1; i++) {
    	    contador2 = 1;
    	    array_info3[i] = [];
    	    array_info3[i][0] = [materiais[i].name,'Size'];
    	    for (var j = 0;  j <= segmentos[i].length - 1; j++) {
    	        
    	        if (materiais[i].id == segmentos[i][j].id_material){
    	             array_info3[i][contador2] = [materiais[i].name,((segmentos[i][j].comprimento_segmento)*1.56)];
    	             contador2++;
    	            array_info2[contador] = [materiais[i].name,((segmentos[i][j].comprimento_segmento)*1.56)];
    	            contador++;
    	        }
    	    }
    	}
    	
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        
        /**
         * função para desenhar grafico
         * 
        **/
        function drawChart() {
            var data = google.visualization.arrayToDataTable(array_info);
            var options = {
                title: 'Average grain number per Meter',
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
            
            var data2 = google.visualization.arrayToDataTable(array_info2);
            var options2 = {
                  title: 'Grain Size, in micrometros',
                  legend: { position: 'none' },
                  colors: ['#ff0000']
            };
            var chart2 = new google.visualization.Histogram(document.getElementById('chart_div'));
            chart2.draw(data2, options2);
            
            //graficos para cada material
            
            var data3 = [];
            var options3 = [];
            var chart3 = [];
            for (var i = 0;  i < array_info3.length; i++) {
                $('#graficos').append('<div id="chart_'+i+'" style="width: 900px; height: 500px;"></div>');
                data3[i]=google.visualization.arrayToDataTable(array_info3[i]);
        	    options3[i] = {
                      title: ''+ array_info3[i][0][0] + ' Grain Size, in micrometros',
                      legend: { position: 'none' }
                };
                chart3[i] = new google.visualization.Histogram(document.getElementById('chart_' + i));
                chart3[i].draw(data3[i], options3[i]);
    	    }
            
        }
        
    </script>
@endsection
