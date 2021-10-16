@extends('draw_template.content')

@section('css')
<style type="text/css">
	body{
		background-image: url("{{asset('assets/image/loader1.gif')}}");
		background-repeat: no-repeat;
		background-position: center;
	}
	@if($event->background_new_draw!='')
		.main{ background-image: url("{{asset('assets/uploads/background'.'/'.$event->background_new_draw)}}"); }
	@endif
	.draw-btn{
		@if($event->button_background_color!='')
			background-color: {{$event->button_background_color}};
		@endif
		@if($event->button_text_color!='')
			color: {{$event->button_text_color}};
		@endif
		@if($event->button_shadow_color!='')
			box-shadow: 0 7px 10px 0 {{$event->button_shadow_color}};
  			-webkit-box-shadow: 0 7px 10px 0 {{$event->button_shadow_color}};
  			-moz-box-shadow: 0 7px 10px 0 {{$event->button_shadow_color}};
		@endif
	}
</style>
@endsection

@section('content')
<div id="loading">
  <img id="loading-image"  src="{{asset('assets/image/loader1.gif')}}" alt="Loading..." />
</div>

<!-- Main Content -->
	<div class="main-content ld ld-fall-ttb-in" id="animate" style="animation-duration:1s">
		<!-- Main -->
		<div class="main text-center font-weight-bold">
			<div class="main-head">
				<h2 class="bold mb-0 ld ld-grow-btt-in" style="animation-delay:2.2s">New Draw</h2>
				<hr class="line-title col-md-3 mt-2 ld ld-power-on" style="animation-delay:1.5s"></hr>
				<p class="ld ld-slide-ttb-in" style="animation-delay:2.9s">Scroll and choose one category and click Draw!</p>
			</div>

			<div class="main-body text-center ld ld-spring-btt-in" style="animation-delay:0.9s">
				<div class="wrap-container" id="wrap-scroll">
				    <ul id="ul-scroll" class="ul-scroll">
				    	@if(count($category) < 1)
				    		No category available
				    	@else
				    	@foreach ($category as $row)
					    	<li class="{{($loop->index == 0)?'selected':''}}" value="{{$row->id}}" tabindex="-1" id="{{ $loop->index }}"> <span class="item">{{$row->name}} </span> </li>
					    @endforeach
					    @endif
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
				@if(count($category) > 0)
				<button class="draw-btn draw-btn-lg ld ld-jump ld-bounce-in" onclick="goToDraw()" style="animation-delay:3s"> Draw</button>
				@endif
			</div>
		</div>
		<!-- End of Main -->
	</div>
<!-- End of Main Content -->

@endsection

@section('script')
<script type="text/javascript">
	var url = {!! json_encode(URL::to('/eo/dashboard_event/recent')) !!};
	let dashboard = {!! json_encode(URL::to('/eo/dashboard_event'.'/'.Session::get('event_id'))) !!};
	let cat = {!! json_encode(count($category)) !!};
</script>

<script>
  $(document).ready( function() {
  	setTimeout(function(){
  		$("#loading").hide();
  		// $("#loading").fadeOut("slow");
  	}, 500);
  	if(cat<1){
  		swal({   
            title: 'Oopsie..',   
            text: "You don't have any draw category, so you can not to draw. Back to event dashboard and create a new category!", 
            icon: 'warning',      
        });
        location.href=dashboard; 
  	}
  });
</script>


<!-- <script src="{{asset('assets/js/draw-shortcut.js')}}"></script> -->
@endsection