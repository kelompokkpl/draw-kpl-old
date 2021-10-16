@extends('crudbooster::admin_template')
@push('head')
 <link href="{{ asset("assets/css/highchart.css")}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
<figure class="highcharts-figure">
  <div id="container"></div>
  <p class="highcharts-description">
    
  </p>
</figure>

<figure class="highcharts-figure">
  <div id="container-pie"></div>
  <p class="highcharts-description">
    
  </p>
</figure>

@endsection

@push('bottom')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="{{ asset ('assets/js/highchart.js')}}"></script>
@endpush