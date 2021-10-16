<div id="loading">
  <img id="loading-image" src="{{asset('assets/image/loader1.gif')}}" alt="Loading..." />
</div>

	<!-- Main Content -->
	<div class="main-content" id="main-content" data-intro='Click Redraw button or press Enter if you want to Redraw'>

		<div class="head">
			<button class="draw-btn" id="redraw" onclick="goToDraw()" value="{{Session::get('category_id')}}">Re-draw</button>
		</div>

		<!-- Main -->
		<div class="main text-center font-weight-bold">
			<div class="main-head">
				<h1 class="mb-0 ld ld-bounce-alt-in infinite" style="animation-duration:2.0s">CONGRATULATIONS !</h1>
				<hr class="line-title col-md-2 mt-2 ld ld-flip-h-in" style="animation-delay: 1.25s"></hr>
			</div>
			
			<div id="carouselExampleControls" class="carousel slide col-md-12 ld ld-zoom-in" style="animation-delay: 2s" data-ride="carousel">
	
				<div class="carousel-inner">
				@php $i=1; @endphp
				@foreach($winner as $row)
				@if($i%20==1)
					<div class="carousel-item <?=($i==1) ? 'active' : ''?>" style="padding: 0!important">
						<div class="row text-lato text-center" style="padding: 0">
				@endif
				<div class="col-md-3 mb-4 mx-auto" style="display: inline-block;">
					{{$row['name']}}<br>
					<span class="text-lato-thin">{{$row['participant_id']}}</span>
				</div>

				@if($i%20==0)
					</div>
				</div>
				@endif
				@php $i++; @endphp
				@endforeach
				</div>
			</div>
		</div>
	</div>
			
			@if(count(Session::get('demo_winners'))>20)
			<div class="main-footer ld ld-zoom-in" style="animation-delay: 2s; position:absolute!important; bottom: 5%!important; left:42.75%">
				<a class="" href="#carouselExampleControls" role="button" data-slide="prev">
				    <button class="draw-btn">Prev</button>
				</a>
				<a class="" href="#carouselExampleControls" role="button" data-slide="next">
				    <button class="draw-btn">Next</button>
				</a>
			</div>
			@endif
		</div>
	</div>

	<script src="{{asset('assets/js/confetti.js')}}"></script>
	<script type="text/javascript">
	    $(document).ready(function() {
	    	$('.carousel').carousel({
				interval: 10000

			})
	        startConfetti();
	        setInterval(stopConfetti,5000);
	        setTimeout(function(){
		  		$("#loading").fadeOut("slow");
		  		introJs().start();
		  	}, 500);
	    });
	</script>
	<script src="{{asset('assets/js/draw-shortcut.js')}}"></script>
