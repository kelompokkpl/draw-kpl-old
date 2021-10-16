<style type="text/css">
	@if($event->background_recent_draw!='')
		.main{ background-image: url("{{asset('assets/uploads/background'.'/'.$event->background_recent_draw)}}"); }
	@endif
	@if($event->global_text_color!='')
		body{ color: {{$event->global_text_color}}!important; }
	@endif
	@if($event->hr_color!='')
		.line-title{ background-color: {{$event->hr_color}}; }
	@endif
</style>

	<!-- Main Content -->
	<div class="main-content ld ld-grow-rtl-in">
		<!-- Main -->
		<div class="main text-center font-weight-bold" id="drawing">
			<div class="main-head">
				<h1 class="mb-0">{{Session::get('category_name')}}</h1>
				<hr class="line-title col-md-3 mt-2"></hr>
			</div>
			<div class="row text-lato text-center align-items-center">
				@php
					if(count(Session::get('parts'))>20){
						$count = 20;
					} else{
						$count = count(Session::get('parts'));
					}
				@endphp
				@for($i = 0; $i < $count; $i++)
				<div class="col-md-3 mb-4 mx-auto" id="part{{$i}}" style="overflow: hidden;">
					
				</div>
				@endfor
			</div>

			<div class="main-footer">
				<!-- <button id="toggle"></button> -->
			</div>
		</div>
		<!-- End of Main -->
	</div>
	<!-- End of Main Content -->
	<script type="text/javascript">
		var winner_url = {!! json_encode(URL::to('/eo/dashboard_event/winner')) !!};
		var participant = {!! json_encode(Session::get('parts')) !!};
		var countParticipant = {!! json_encode(count(Session::get('parts'))) !!};
	</script>
	<script src="{{asset('assets/js/draw-animate.js')}}"></script>
	<script src="{{asset('assets/js/draw-shortcut.js')}}"></script>