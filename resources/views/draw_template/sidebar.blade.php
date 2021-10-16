	<!-- Sidebar -->
	<aside class="sidebar">
      	<div class="toggle">
        	<a href="#" class="burger js-menu-toggle ld ld-throw-ltr-in" data-toggle="collapse" data-target="#main-navbar" style="animation-delay: 1.7s">
              	<span></span>
            </a>
      	</div>
      	<div class="side-inner">        
	        <div class="nav-menu text-left">
	        	<ul id="menu-sidebar">
		            <li class="menu-item{{(Str::contains(URL::current(), 'dashboard_event/draw')) ? ' active' : '' }}" value="draw" onclick="goToNew()"><a href="#">New Draw</a></li>
		            <li class="menu-item{{(Str::contains(URL::current(), 'dashboard_event/recent')) ? ' active' : '' }}" value="recent" onclick="goToRecent()"><a href="#">Recent Draw</a></li>
		            <li class="menu-item{{(Str::contains(URL::current(), 'dashboard_event/history')) ? ' active' : '' }}" value="history" onclick="goToHistory()"><a href="#">Draw History</a></li>
	        	</ul>
	        </div>
    	</div>  
    </aside>
	<!-- End of Sidebar -->

	<script type="text/javascript">
		var menu_url = {!! json_encode(URL::to('eo/dashboard_event/')) !!}
	</script>