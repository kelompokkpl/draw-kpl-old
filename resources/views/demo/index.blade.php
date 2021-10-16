@extends('demo_template.content')

@section('content')
<span data-step="1" data-intro="Hello! 👋 We will explore on this tour. Get ready and don't forget your seat belt!"></span>
<span data-step="2" data-intro='Ouhh.. you can press F to get full screen. Cool, right?'></span>
<div id="loading">
  <img id="loading-image"  src="{{asset('assets/image/loader1.gif')}}" alt="Loading..." />
</div>

<!-- Main Content -->
	<div class="main-content ld ld-fall-ttb-in" id="animate" style="animation-duration:1s">
		<!-- Main -->
		<div class="main text-center font-weight-bold">
			<div class="main-head">
				<h2 class="bold mb-0 ld ld-grow-btt-in" style="animation-delay:2.2s" data-step="3" data-intro='This is the New Draw page. You can do a new draw here ✨ You can press Alt+N to open this page'>New Draw</h2>
				<hr class="line-title col-md-3 mt-2 ld ld-power-on" style="animation-delay:1.5s"></hr>
				<p class="ld ld-slide-ttb-in" style="animation-delay:2.9s">Scroll and choose one category and click Draw!</p>
			</div>

			<div class="main-body text-center ld ld-spring-btt-in" style="animation-delay:0.9s">
				<div class="wrap-container" id="wrap-scroll" data-step="5" data-intro='This is the category option. Scroll or press the up or down to ride it' data-position="top">
				    <ul id="ul-scroll" class="ul-scroll">
						<li class="selected" value="1" tabindex="-1" id="0"> <span class="item">This is Category One</span></li>
						<li value="2" tabindex="-1" id="1"> <span class="item">I'm Category Two</span></li>
						<li value="3" tabindex="-1" id="2"> <span class="item">Category Three</span></li>
				    </ul>
				</div>

				<!-- Mask -->
				<svg>
					<defs>
						<linearGradient id="gradient" x1="0" y1="0%" x2 ="0" y2="50%">
					  		<stop stop-color="black" offset="0"/>
					  		<stop stop-color="white" offset="1"/>
						</linearGradient>
						<mask id="masking" maskUnits="objectBoundingBox" maskContentUnits="objectBoundingBox">
					  		<rect y="0" width="1" height="1" fill="url(#gradient)" />
						</mask>
					</defs>
				</svg> 

			</div>

			<div class="main-footer">
				<button class="draw-btn draw-btn-lg ld ld-jump ld-bounce-in" onclick="goToDraw()" style="animation-delay:3s" data-step="6" data-intro='This is the last one! Press this button or press Enter to continue Draw'> Draw</button>
			</div>
		</div>
		<!-- End of Main -->
	</div>
<!-- End of Main Content -->

@endsection

@section('script')
<script type="text/javascript">
	var url = {!! json_encode(URL::to('/recent')) !!};
	let dashboard = {!! json_encode(URL::to('/eo/dashboard_event'.'/'.Session::get('event_id'))) !!};
</script>

<script>
  $(document).ready( function() {
  	setTimeout(function(){
  		$("#loading").hide();
  	}, 500);
  	introJs().start();
  });
</script>


<!-- <script src="{{asset('assets/js/draw-shortcut.js')}}"></script> -->
@endsection