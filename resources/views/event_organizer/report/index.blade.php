<!-- First you need to extend the CB layout -->
@extends('event_organizer_template.eo_template')

@section('content-header')
        <section class="content-header">
            <h1> <i class='fa fa-bars'></i> Event Report&nbsp;&nbsp;</h1>
                <ol class="breadcrumb">
                    <li><a href="{{URL::to('eo/report')}}"><i class="fa fa-bars"></i> Event</a></li>
                    <li class="active">Report</li>
                </ol>
        </section>
@endsection

@section('content')
<!-- Your custom  HTML goes here -->

<style type="text/css">
  .required{
    color: red;
    font-weight: bold;
  }
  th{
    width: 15%;
  }
  ul, li{
    margin-left: 2px;
  }
</style>

<div class='panel panel-default' id="root">
    <div class="panel-body">
        <form method="POST" action="{{route('print_report')}}" id="form">
          @csrf
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <!-- Event<span class="required">*</span> -->
                <br>
                <select name="event_id" class="form-control" v-model="event_selected" @change="eventOnChange" required>
                  <option disabled value="">** Please select a event</option>
                  @foreach($event as $row)
                    <option value="{{$row->id}}">{{$row->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group"><br>
                <button type="submit" class="btn btn-info" v-if="events.length" :disabled="isDisabled" target="_blank">Print</button>
              </div>
            </div>

          </div>
          <hr>

          @include('event_organizer.report.report_data')

          <!-- ADD A PAGINATION -->
          <!-- <p>urldecode(str_replace("/?","?",$participant->appends(Request::all())->render()))</p> -->
      </form>
    </div>
</div>
@endsection

@prepend('bottom')
<script type="text/javascript">
    var basepath = {!! json_encode(URL::to('/eo')) !!};
    var page = 'category_disabled';
</script>

<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script src="https://unpkg.com/axios@0.20.0-0/dist/axios.min.js"></script>
<script src="{{ asset ('assets/js/report.js')}}"></script>
@endprepend