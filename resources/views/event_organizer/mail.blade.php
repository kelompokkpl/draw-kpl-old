<!-- First you need to extend the CB layout -->
@extends('event_organizer_template.eo_template')

@section('content-header')

        <section class="content-header">
            <h1> <i class='fa fa-envelope'></i> Mails to Winner &nbsp;&nbsp;

              <a href="{{URL::to('eo/dashboard_event/mails')}}" id='btn_show_data' class="btn btn-sm btn-primary" title="Show Data Event">
                  <i class="fa fa-table"></i> Show Data
              </a>

              <a href="{{URL::to('eo/dashboard_event/mails/create')}}" id='btn_show_data' class="btn btn-sm btn-success" title="Add Data Event">
                  <i class="fa fa-pencil"></i> Compose Email
              </a>

            </h1>

                <!-- END BUTTON -->
                </h1>


                <ol class="breadcrumb">
                    <li><a href="{{URL::to('eo/dashboard_event')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li class="active">Mails to Winner</li>
                </ol>
        </section>
@endsection

@section('content')
<!-- Your custom  HTML goes here -->
<div class='panel panel-default' id="root">
    <div class="panel-body">
      <table class='table table-striped table-bordered datatables-simple'>
        <thead>
            <tr>
              <th>Timestamp</th>
              <th>Category Name</th>
              <th>Subject</th>
              <th class="text-right">Action</th>
             </tr>
        </thead>
        <tbody>
          @foreach($mail as $row)
            <tr>
              <td>{{date('F d, Y', strtotime($row->created_at))}} at {{date('H:i', strtotime( $row->created_at))}}</td>
              <td>{{$row->name}}</td>
              <td>{{$row->subject}}</td>
              <td class="text-right">
                <a class='btn btn-xs btn-primary btn-detail' title='Detail Data' href='{{ route('mails.show', $row->id) }}'>
                  <i class='fa fa-eye'></i>
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
</div>

@endsection