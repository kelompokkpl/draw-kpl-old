@extends('crudbooster::admin_template')
@push('head')
 <link href="{{ asset("assets/css/highchart.css")}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
<!-- Total -->
      <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
          <a href="{{URL::to('admin/event')}}" style="color: black">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-bars"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Event</span>
              <span class="info-box-number">{{$event}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          </a>
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <a href="{{URL::to('admin/payment')}}" style="color: black">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-credit-card"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Payment Transactions</span>
              <span class="info-box-number">{{$transaction}}</span>
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
          <a href="{{URL::to('admin/payment')}}" style="color: black">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Payment</span>
              <span class="info-box-number">Rp{{number_format($payment,0)}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          </a>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

<!-- Chart -->
	<div class="row">
		<div class="col-md-4">
    <!-- Payment Chart -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Upcoming Event Payment Chart</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="chart">
                    <!-- Payment Chart Canvas -->
                    <figure class="highcharts-figure">
                      <div id="container-pie"></div>
                      <p class="highcharts-description">
                        <!-- desk -->
                      </p>
                    </figure>
                  </div>
                  <!-- /.chart-responsive -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
          </div>

      <!-- end of payment chart -->
      	</div>

      	<div class="col-md-8">
      		<!-- Sales Chart -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Sales Chart</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="chart">
                    <!-- Activity Chart Canvas -->
                    <figure class="highcharts-figure">
                      <div id="sales"></div>
                      <p class="highcharts-description">
                      </p>
                    </figure>
                  </div>
                  <!-- /.chart-responsive -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
          </div>
    <!-- end of sales chart -->
   		</div>
   	</div>

   	<!-- Activity Chart -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Activity Chart</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="chart" style="width: 100%; padding: 0!important">
                    <!-- Activity Chart Canvas -->
                    <figure class="highcharts-figure">
                      <div id="container"></div>
                      <p class="highcharts-description">
                      </p>
                    </figure>
                  </div>
                  <!-- /.chart-responsive -->
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
 	let payment = {!! json_encode($pay_chart) !!}
  	let series = {!! json_encode($series) !!}
  	let drillDown = {!! json_encode($drilldown) !!}
  	let income = {!! json_encode($income) !!}
  	let monthName = [
	  "Jan", "Feb", "March", "Apr", "May", "June",
	  "July", "Aug", "Sept", "Oct", "Nov", "Dec"
	];
  	let month = [];
  	let total = [];
  	for (let i = 0; i < income.length; i++) {
  		month.push(monthName[(income[i].month)-1])
  		total.push(income[i].y)
  	}
</script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="{{ asset ('assets/js/dashboard-admin.js')}}"></script>
@endpush