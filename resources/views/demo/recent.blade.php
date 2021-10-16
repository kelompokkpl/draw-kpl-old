<div id="loading">
  <img id="loading-image" src="{{asset('assets/image/loader1.gif')}}" alt="Loading..." />
</div>
	<!-- Main Content -->
	<div class="main-content" id="animate">
		<!-- Main -->
		<div class="main text-center font-weight-bold">
			<div class="main-head">
				<h1 class="mb-0 ld ld-slide-btt-in" style="animation-delay:2.5s" data-step="1" data-intro='Hi.. This is the Recent Page. You can press Alt+R to open this page'>{{Session::get('demo_category_name')}}</h1>
				<hr class="line-title col-md-3 mt-2 ld ld-power-on" style="animation-delay:1.9s"></hr>
			</div>

			<div class="main-body text-center ld ld-zoom-in" style="animation-delay: 1.25s">
				<!-- Draw Button -->
				<img src="{{asset('assets/image/img_draw_button.png')}}" class="draw mt-2 ld ld-heartbeat" onclick="goToDraw()" data-step="2" data-intro='Click or enter to continue draw'>
			</div>

			<div class="main-footer mt-4 ld ld-slide-ttb-in" style="animation-delay: 2.8s">
				<h4 class="text-uppercase">Draw and find the winner!</h4>
			</div>
		</div>
		<!-- End of Main -->
	</div>
	<!-- End of Main Content -->

<script type="text/javascript">
	var drawing_url = {!! json_encode(URL::to('/drawing')) !!};
</script>

<script src="{{asset('assets/js/draw-shortcut.js')}}"></script>
<script>
  $(document).ready( function() {
	let cat_name = {!! json_encode(Session::get('demo_category_name')) !!};
	let draw = {!! json_encode(URL::to('/demo')) !!};
  	setTimeout(function(){
  		 $("#loading").fadeOut("slow");
  		 introJs().start();
  	}, 500);

  	if(cat_name==''){
  		swal({   
            title: 'Oopsie..',   
            text: "Recent draw is not found! Get start it with New Draw", 
            icon: 'warning',      
        });
        setTimeout(function(){
  			swal.close();
  			goToNew();
  		}, 2000); 
  	}
  });
</script>