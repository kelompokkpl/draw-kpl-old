<div id="carouselExampleControls" class="carousel slide col-md-12 ld ld-zoom-in" style="animation-delay: 2s" data-ride="carousel">

			<div class="carousel-inner">
				<div v-if="!winners.length" class="row text-lato text-center">
					<div class="text-center mx-auto"><h3>No Data Available</h3></div>
				</div>

				<template v-for="n in Math.ceil((winners.length)/20)">
					<div class="carousel-item active" style="padding: 0!important" v-if="n==1">
						<div class="row text-lato text-center" style="padding: 0">
							<div class="col-md-3 mb-4 mx-auto" style="display: inline-block;" v-for="(winner, index) in winners" v-if="index < 20">
								@{{winner.name}}<br>
								<span class="text-lato-thin">@{{winner.participant_id}}</span>
							</div>
						</div>
					</div>
					<div class="carousel-item" style="padding: 0!important" v-if="n>1">
						<div class="row text-lato text-center" style="padding: 0">
							<div class="col-md-3 mb-4 mx-auto" style="display: inline-block;" v-for="(winner, index) in winners" v-if="index >= 20 && index < (20*n-1)">
								@{{winner.name}}<br>
								<span class="text-lato-thin">@{{winner.participant_id}}</span>
							</div>
						</div>
					</div>
				</template>


			</div>		
		</div>


			<div  v-if="winners.length > 20" class="main-footer ld ld-zoom-in" style="animation-delay: 2s; position:absolute!important; bottom: 5%!important; left:42.75%">
				<a class="" href="#carouselExampleControls" role="button" data-slide="prev">
				    <button class="draw-btn">Prev</button>
				</a>
				<a class="" href="#carouselExampleControls" role="button" data-slide="next">
				    <button class="draw-btn">Next</button>
				</a>
			</div>
				</div>
</div>