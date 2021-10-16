@extends('event_organizer_template.eo_template')

@push('head')
 <link href="{{ asset("assets/css/highchart.css")}}" rel="stylesheet" type="text/css" />
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
          <a href="{{URL::to('eo/event')}}" style="color: black">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-bars"></i></span>

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

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-4 col-sm-6 col-xs-12">
          <a href="{{URL::to('eo/event?held=past')}}" style="color: black">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-arrow-circle-left"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Past Event</span>
              <span class="info-box-number">{{$past}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          </a>
        </div>
        <!-- /.col -->

        <div class="col-md-4 col-sm-6 col-xs-12">
          <a href="{{URL::to('eo/event?held=upcoming')}}" style="color: black">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-location-arrow"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Upcoming Event</span>
              <span class="info-box-number">{{$upcoming}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          </a>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-md-8">
      <!-- Activity Chart -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Activity Chart</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  @if(!empty($drilldown))
                  <div class="chart">
                    <!-- Activity Chart Canvas -->
                    <figure class="highcharts-figure">
                      <div id="container"></div>
                      <p class="highcharts-description">
                        
                      </p>
                    </figure>
                  </div>
                  <!-- /.chart-responsive -->
                  @else
                  <div style="text-align: center; margin: 30px 0 30px 0">No activities available</div>
                  @endif
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
          </div>
        </div>
    <!-- end of activity chart -->

<!-- Chart -->
    <!-- Payment Chart -->
        <div class="col-md-4">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Upcoming Event Payment Chart</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  @if(!($payment['paid']==0 && $payment['unpaid']==0))
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
                  @else
                  <div style="text-align: center; margin: 30px 0 30px 0">No payment available</div>
                  @endif
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
          </div>
        </div>
      </div>
      <!-- end of payment chart -->

@endsection

@push('bottom')
<script type="text/javascript">
  let payment = {!! json_encode($payment) !!}
  let series = {!! json_encode($series) !!}
  let drillDown = {!! json_encode($drilldown) !!}
</script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="{{ asset ('assets/js/dashboard-eo.js')}}"></script>
@endpush