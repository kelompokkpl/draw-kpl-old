	<!-- Main Content -->
	<div class="main-content ld ld-fall-ttb-in" style="animation-duration:1s" id="root" data-intro='This is the History Draw page. You can open this page with press Alt+H ✨' data-position="auto">
		<!-- Main -->
		<div class="main2 text-center font-weight-bold">
			<div class="main-head text-left col-md-5">
				<small>Choose draw category</small><br>
				<form action="" method="POST">
					<select name="category_id" id="category_select" class="draw-select" v-model="selected_category" @change="getWinners" autofocus>
						<option value="" tabindex="-1">Please select a category</option>
						<option value="1" tabindex="-1">This is Category One</option>
						<option value="2" tabindex="-1">I'm Category Two</option>
						<option value="3" tabindex="-1">Сategory Three</option>
					</select>
				</form>
			</div>
			
			@include('draw_layout.history_data')

		</div>
	</div>


<script type="text/javascript">
	introJs().start();
	var basepath = {!! json_encode(URL::to('/')) !!};
	$('#category_select').focus();
</script>

<script src="{{ asset ('assets/js/draw_winners.js')}}"></script>
<script src="{{asset('assets/js/draw-shortcut.js')}}"></script>