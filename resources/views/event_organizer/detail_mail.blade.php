<!-- First you need to extend the CB layout -->
@extends('event_organizer_template.eo_template')

@section('content-header')
        <section class="content-header">
            <h1> <i class='fa fa-envelope'></i> Mail to Winner &nbsp;&nbsp;

              <a href="{{URL::to('eo/dashboard_event/mails')}}" id='btn_show_data' class="btn btn-sm btn-primary" title="Show Data">
                  <i class="fa fa-table"></i> Show Data
              </a>

            </h1>
                <ol class="breadcrumb">
                    <li><a href="{{URL::to('eo/dashboard_event/mails')}}"><i class="fa fa-bars"></i> Mail to Winner</a></li>
                    <li class="active">Detail</li>
                </ol>
        </section>
@endsection
@section('content')
  <!-- Your html goes here -->
  <div class='panel panel-default'>
    <div class='panel-heading'>Detail Mails</div>
    <div class='panel-body'>
      <div class="row">
        <div class='col-md-2'>
          <label>Send To</label>
        </div>
   
        <div class='col-md-10'>
          : All <strong>{{$mail->name}}</strong>'s winners
        </div>
      </div>      
      <div class="row">
        <div class='col-md-2'>
          <label>Timestamp</label>
        </div>
        <div class='col-md-10'>
          : {{date('F d, Y', strtotime($mail->created_at))}} at {{date('H:i', strtotime( $mail->created_at))}}
        </div>
      </div> 

      <div class="row">
         <div class='col-md-2'>
          <label>Content</label>
        </div>
        <div class='col-md-10'>:</div>
      </div>
      <div class="row">
         <div class='col-md-2'>
        </div>
        <div class='col-md-8 rounded' style="box-shadow: 0 0 10px #f2f2f2; border: solid 1px transparent; margin-left: 30px; padding: 25px">
          <h4><b>{{ $mail->subject }}</b></h4>
          {!! $mail->content !!}
        </div>
      </div>

    </div>
  </div>
@endsection