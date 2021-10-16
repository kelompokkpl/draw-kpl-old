<!-- First you need to extend the CB layout -->
@extends('event_organizer_template.eo_template')

@section('content-header')
        <section class="content-header">
            <h1> <i class='fa fa-bars'></i> Category Disabled &nbsp;&nbsp;

              <a href="{{URL::to('eo/dashboard_event/category_disabled')}}" id='btn_show_data' class="btn btn-sm btn-primary" title="Show Data Category Disabled">
                  <i class="fa fa-table"></i> Show Data
              </a>
              <a href="{{URL::to('eo/dashboard_event/add_selected_participant')}}" class="btn btn-sm btn-success" title="Show Data Category Disabled">
                  <i class="fa fa-check"></i> Add Data
              </a>

            </h1>

            <ol class="breadcrumb">
                <li><a href="{{URL::to('eo/dashboard_event')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Category Disabled</li>
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
              <th>Category</th>
              <th>Participant Name</th>
              <th class="text-right">Action</th>
             </tr>
        </thead>
        <tbody>
          @foreach($category_disabled as $row)
            <tr>
              <td>{{$row->category_name}}</td>
              <td>{{$row->participant_name}}</td>
              <td class="text-right">
                <a class='btn btn-xs btn-success btn-detail' title='Enable Participant' href='javascript:;' 
                  onclick="swal({   
                    title: 'Confirmation',   
                    text: 'Are you sure to enable this participant?',   
                    type: 'warning',   
                    showCancelButton: true,   
                    confirmButtonColor: '#ff0000',   
                    confirmButtonText: 'Yes!',  
                    cancelButtonText: 'No',  
                    closeOnConfirm: false 
                  }, 
                  function(){ 
                    location.href='{{URL::to('eo/enable_participant/'.$row->id)}}' 
                  });">
                  <i class='fa fa-check'></i> Enable
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
</div>
@endsection