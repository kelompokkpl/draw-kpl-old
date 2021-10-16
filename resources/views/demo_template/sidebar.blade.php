	<!-- Sidebar -->
	<aside class="sidebar">
      	<div class="toggle">
      		@if(Str::contains(URL::current(), 'demo'))
        	<a href="#" class="burger js-menu-toggle ld ld-throw-ltr-in" data-toggle="collapse" data-target="#main-navbar" style="animation-delay: 1.7s" data-step="4" data-intro="Wow, there's a burger! No no.. This is the sidebar menu. Click here or press the M button to open it">
              	<span></span>
            </a>
            @else
            <a href="#" class="burger js-menu-toggle ld ld-throw-ltr-in" data-toggle="collapse" data-target="#main-navbar" style="animation-delay: 1.7s">
              	<span></span>
            </a>
            @endif
      	</div>
      	<div class="side-inner">        
	        <div class="nav-menu text-left">
	        	<ul id="menu-sidebar">
		            <li class="menu-item{{(Str::contains(URL::current(), 'demo')) ? ' active' : '' }}" value="draw" onclick="goToNew()"><a href="#">New Draw</a></li>
		            <li class="menu-item{{(Str::contains(URL::current(), 'recent')) ? ' active' : '' }}" value="recent" onclick="goToRecent()"><a href="#">Recent Draw</a></li>
		            <li class="menu-item{{(Str::contains(URL::current(), 'history')) ? ' active' : '' }}" value="history" onclick="goToHistory()"><a href="#">Draw History</a></li>
	        	</ul>
	        </div>
    	</div>  
    </aside>
	<!-- End of Sidebar -->

	<script type="text/javascript">
		var menu_url = {!! json_encode(URL::to('')) !!}
	</script>