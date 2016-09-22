@extends('layouts.app')

@section('content')
<div class="container">
    <p><a href="{{ url('/') }}">Home</a>&nbsp> About Page</a></p>
   
   <br>
   <div class="container mtb">
	 	<div class="row">
	 		<div class="col-lg-6">
	 			<img class="img-responsive" src="{{URL::asset('src/182.jpg')}}" alt="">
	 		</div>
	 		
	 		<div class="col-lg-6">
	 			<h4><b>About this Application:</b></h4>
		 		<p>This application is used to make stereological studies of materials created in the laboratory ESTG.</p>
		 		<p>Stereology is the three-dimensional interpretation of two-dimensional cross sections of materials or tissues. 
		 		It provides practical techniques for extracting quantitative information about a three-dimensional material 
		 		from measurements made on two-dimensional planar sections of the material. Stereology is a method that utilizes random, 
		 		systematic sampling to provide unbiased and quantitative data.</p>
		 		<p>With this data, this application calculates the average grain size and also a histogram of the size of the grains of the material.</p>
		 		<h4><b>About this project:</b></h4>
		 		<p>Application developed by the students João Viana and Jorge Cunha, with the Scientific supervision of professor João Abrantes and Technical supervision of professor Pedro Moreira.</p>
		 		<p>This application was developed in "Project IV" lecture of the Software Engineering Course.</p>
		 		<p>Escola Superior de Tecnologia e Gestão - Instituto Politécnico de Viana do Castelo.</p>
		 		<a class="btn btn-primary" href="{{ URL::asset('src/UserManual.pdf')}}">Download User's Manual</a>
	 		</div>
	 	</div><! --/row -->
	 </div><! --/container -->
	 
	 <!-- *****************************************************************************************************************
	 TEEAM MEMBERS
	 ***************************************************************************************************************** -->

	 <div class="container mtb">
	 	<div class="row centered">
		 	<h3 class="mb">MEET OUR TEAM</h3>
		 	
		 	<div class="col-lg-3 col-md-3 col-sm-3">
				<div class="he-wrap tpl6">
				<img  class="img-responsive" src="{{URL::asset('src/tiagoimg2.jpg')}}" alt="">
					<div class="he-view">
						<div class="bg a0" data-animate="fadeIn">
                            <h3 class="a1" data-animate="fadeInDown">Contact:</h3>
                            <a href="#" class="dmbutton a2" data-animate="fadeInUp"><i class="fa fa-envelope"></i></a> joaoviana@ipvc.pt
                    	</div><!-- he bg -->
					</div><!-- he view -->		
				</div><!-- he wrap -->
				<h4>João Viana</h4>
				<h5 class="ctitle">Developer</h5>
				<p>Student in Software Engineering</p>
				<div class="hline"></div>
		 	</div><! --/col-lg-3 -->

		 	<div class="col-lg-3 col-md-3 col-sm-3">
				<div class="he-wrap tpl6">
				<img  class="img-responsive" src="{{URL::asset('src/jorgeimg2.jpg')}}" alt="">
					<div class="he-view">
						<div class="bg a0" data-animate="fadeIn">
                            <h3 class="a1" data-animate="fadeInDown">Contact:</h3>
                            <a href="#" class="dmbutton a2" data-animate="fadeInUp"><i class="fa fa-envelope"></i></a> jorgeca@ipvc.pt
                    	</div><!-- he bg -->
					</div><!-- he view -->		
				</div><!-- he wrap -->
				<h4>Jorge Cunha</h4>
				<h5 class="ctitle">Developer</h5>
				<p>Student in Software Engineering</p>
				<div class="hline"></div>
		 	</div><! --/col-lg-3 -->

		 	<div class="col-lg-3 col-md-3 col-sm-3">
				<div class="he-wrap tpl6">
				<img  class="img-responsive" src="{{URL::asset('src/moreiraimg.jpg')}}" alt="">
					<div class="he-view">
						<div class="bg a0" data-animate="fadeIn">
                            <h3 class="a1" data-animate="fadeInDown">Contact:</h3>
                            <a href="#" class="dmbutton a2" data-animate="fadeInUp"><i class="fa fa-envelope"></i></a> pmoreira@estg.ipvc.pt
                            
                    	</div><!-- he bg -->
					</div><!-- he view -->		
				</div><!-- he wrap -->
				<h4>Pedro Moreira</h4>
				<h5 class="ctitle">Technical Advisor</h5>
				<p>PhD in Electrical and Computer Engineering, University of Porto.</p>
				<div class="hline"></div>
		 	</div><! --/col-lg-3 -->

		 	<div class="col-lg-3 col-md-3 col-sm-3">
				<div class="he-wrap tpl6">
				<img  class="img-responsive" src="{{URL::asset('src/joaoabrantes.jpg')}}" alt="">
					<div class="he-view">
						<div class="bg a0" data-animate="fadeIn">
                            <h3 class="a1" data-animate="fadeInDown">Contact:</h3>
                            <a href="#" class="dmbutton a2" data-animate="fadeInUp"><i class="fa fa-envelope"></i></a> jabrantes@estg.ipvc.pt
                            
                    	</div><!-- he bg -->
					</div><!-- he view -->		
				</div><!-- he wrap -->
				<h4>João Abrantes</h4>
				<h5 class="ctitle">Scientific Advisor</h5>
				<p>PhD in Materials Science and Engineering from the University of Aveiro.</p>
				<div class="hline"></div>
		 	</div><! --/col-lg-3 -->		 	
		 	
	 	</div><! --/row -->
	 </div><! --/container -->

</div>
@endsection
