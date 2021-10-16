<!-- First you need to extend the CB layout -->
@extends('event_organizer_template.eo_template')

@section('content-header')
        <section class="content-header">
            <h1> <i class='fa fa-bars'></i> Event &nbsp;&nbsp;

              <a href="{{URL::to('eo/event')}}" id='btn_show_data' class="btn btn-sm btn-primary" title="Show Data Event">
                  <i class="fa fa-table"></i> Show Data
              </a>

            </h1>
                <ol class="breadcrumb">
                    <li><a href="{{URL::to('eo/event')}}"><i class="fa fa-bars"></i> Event</a></li>
                    <li class="active">Detail</li>
                </ol>
        </section>
@endsection
@section('content')
  <!-- Your html goes here -->
  <div class='panel panel-default'>
    <div class='panel-heading'>Detail Event</div>
    <div class='panel-body'>
      <div class="row">
        <div class='col-md-2'>
          <label>Event Name</label>
        </div>
        <div class='col-md-10'>
          : {{$event->name}}
        </div>
      </div>      

      <div class="row">
         <div class='col-md-2'>
          <label>Payment Status</label>
        </div>
        <div class='col-md-10'>
          : {{$event->payment_status}}
        </div>
      </div>

      <div class="row">
         <div class='col-md-2'>
          <label>Status</label>
        </div>
        <div class='col-md-10'>
          : <span class="label label-{{($event->status=='Active')?'success':'default'}}">
              {{$event->status}}
            </span>
        </div>
      </div>

      <div class="row">
        <div class='col-md-2'>
          <label>Date Start</label>
        </div>
        <div class='col-md-10'>
          : {{date("F, d Y", strtotime($event->date_start))}}
        </div>
      </div>

      <div class="row">
         <div class='col-md-2'>
          <label>Date End</label>
        </div>
        <div class='col-md-10'>
          : {{date("F, d Y", strtotime($event->date_end))}}
        </div>
      </div>

      <div class="row">
         <div class='col-md-2'>
          <label>Held</label>
        </div>
        <div class='col-md-10'>
          : 
          @if($event->date_end < date('Y-m-d'))
            <span class="label label-default">Past</span>
          @elseif($event->date_end == date('Y-m-d'))
            <span class="label label-success">Today!</span>
          @else
            <span class="label label-info">Upcoming</span>
          @endif
        </div>
      </div>
      <hr>
    </div>
  </div>
@endsection