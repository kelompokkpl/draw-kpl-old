@extends('event_organizer_template.eo_template')

@push('head')
 <link href="{{ asset("assets/css/highchart.css")}}" rel="stylesheet" type="text/css" />
 <style type="text/css">
	.wrapperr {
	    position:relative;
	    margin:0 auto;
	    overflow:hidden;
		padding:5px;
	  	height:50px;
	}

	.list {
	    position:absolute;
	    left:0px;
	    top:0px;
	  	min-width:3000px;
	  	margin-left:12px;
	    margin-top:0px;
	}

	.list li{
		display:table-cell;
	    position:relative;
	    text-align:center;
	    cursor:grab;
	    cursor:-webkit-grab;
	    color:#efefef;
	    vertical-align:middle;
	}

	.scroller {
	  text-align:center;
	  cursor:pointer;
	  display:none;
	  padding:7px;
	  padding-top:11px;
	  white-space:no-wrap;
	  vertical-align:middle;
	  background-color:#fff;
	}

	.scroller-right{
	  float:right;
	}

	.scroller-left {
	  float:left;
	}
 </style>
@endpush

@section('content-header')
        <section class="content-header">
            <h1> <i class='fa fa-dashboard'></i> Dashboard </h1>
        </section>
@endsection

@section('content')
<!-- Total -->
      <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
          <a href="{{URL::to('eo/dashboard_event/category')}}" style="color: black">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-bars"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Draw Category</span>
              <span class="info-box-number">{{$category}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          </a>
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <a href="{{URL::to('eo/dashboard_event/participant')}}" style="color: black">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Participants</span>
              <span class="info-box-number">{{$participant}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          </a>
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-trophy"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Winners</span>
              <span class="info-box-number">{{$winner}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

<!-- Chart -->
    <!-- winners wordcloud -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Winners</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="chart">
                    @if(count($winners)>0)
                    <!-- Payment Chart Canvas -->
                    <figure class="highcharts-figure">
                      <div id="wordCloud"></div>
                      <p class="highcharts-description">
                        <!-- desk -->
                      </p>
                    </figure>
                    @else
                    <div class="text-center"><h3>Upps.. No data available!</h3>
                     Let's go to draw!<br><br></div>
                    @endif
                  </div>
                  <!-- /.chart-responsive -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
          </div>
      <!-- end of winner -->

      <!-- Activity Chart -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Winners By Category</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                @if(!empty($category))
                	@if(count($cat)>4)
        					<div class="scroller scroller-left"><i class="glyphicon glyphicon-chevron-left"></i></div>
        					<div class="scroller scroller-right"><i class="glyphicon glyphicon-chevron-right"></i></div>
        					@endif
      						<div class="wrapperr">
      						    <ul class="nav nav-tabs list" id="myTab">
      						    	@foreach($cat as $row)
      						    		<li {{ ($loop->index==0)?'class=active':''}}><a data-toggle="tab" href="#{{$row->id}}">{{$row->name}}</a></li>
      						    	@endforeach
      						  </ul>
      						  </div>
						    <div class="tab-content">
							   @foreach($cat as $row)
					        <div id="{{$row->id}}" class="tab-pane fade {{($loop->index==0)?'in active':''}}">
                    <div class="row">
                      <div class="col-md-2"></div>
					            <div class="col-md-8">
					              <table class="table table-bordered table-striped table-responsive datatables-simple">
							          <thead>
							            <tr>
							            	<th style="width:150px">ID</th>
							            	<th>Name</th>
                            <th>Email</th>
							            </tr>
							          </thead>
							          <tbody>
							            @foreach ($win as $r)
							            	@if($r->category_id==$row->id)
								            <tr>
								                <td>{{$r->id}}</td>
								                <td>{{$r->name}}</td>
                                <td>{{$r->email}}</td>
								            </tr>
								            @endif
							            @endforeach
							          </tbody>
							        </table>
					            </div>
                      <div class="col-md-2"></div>
                    </div>
					        </div>
					        @endforeach
					       </div>
                 @else
                  <div class="text-center"><h3>Hmm.. No data available!</h3><br><br></div>
	               @endif

                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
          </div>
    <!-- end of activity chart -->

@endsection

@push('bottom')
<script type="text/javascript">
  	let winners = {!! json_encode($winners) !!}
</script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/wordcloud.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="{{ asset ('assets/js/dashboard-event.js')}}"></script>
@endpush