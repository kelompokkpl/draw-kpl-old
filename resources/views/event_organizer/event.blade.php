<!-- First you need to extend the CB layout -->
@extends('event_organizer_template.eo_template')

@section('content-header')

        <section class="content-header">
            <h1> <i class='fa fa-bars'></i> Event &nbsp;&nbsp;

              <a href="{{URL::to('eo/event')}}" id='btn_show_data' class="btn btn-sm btn-primary" title="Show Data Event">
                  <i class="fa fa-table"></i> Show Data
              </a>

              <a href="{{URL::to('eo/event/create')}}" id='btn_show_data' class="btn btn-sm btn-success" title="Add Data Event">
                  <i class="fa fa-plus-circle"></i> Add Data
              </a>

            </h1>
            <?php
            $module = CRUDBooster::getCurrentModule();
            ?>
            @if($module)
                <h1>
                    <!--Now you can define $page_icon alongside $page_tite for custom forms to follow CRUDBooster theme style -->
                    <i class='{!! ($page_icon)?:$module->icon !!}'></i> {!! ucwords(($page_title)?:$module->name) !!} &nbsp;&nbsp;

                    <!--START BUTTON -->

                    @if(CRUDBooster::getCurrentMethod() == 'getIndex')
                        @if($button_show)
                            <a href="{{ CRUDBooster::mainpath().'?'.http_build_query(Request::all()) }}" id='btn_show_data' class="btn btn-sm btn-primary"
                               title="{{cbLang('action_show_data')}}">
                                <i class="fa fa-table"></i> {{cbLang('action_show_data')}}
                            </a>
                        @endif

                        @if($button_add && CRUDBooster::isCreate())
                            <a href="{{ CRUDBooster::mainpath('add').'?return_url='.urlencode(Request::fullUrl()).'&parent_id='.g('parent_id').'&parent_field='.$parent_field }}"
                               id='btn_add_new_data' class="btn btn-sm btn-success" title="{{cbLang('action_add_data')}}">
                                <i class="fa fa-plus-circle"></i> {{cbLang('action_add_data')}}
                            </a>
                        @endif
                    @endif


                    @if($button_export && CRUDBooster::getCurrentMethod() == 'getIndex')
                        <a href="javascript:void(0)" id='btn_export_data' data-url-parameter='{{$build_query}}' title='Export Data'
                           class="btn btn-sm btn-primary btn-export-data">
                            <i class="fa fa-upload"></i> {{cbLang("button_export")}}
                        </a>
                    @endif

                    @if($button_import && CRUDBooster::getCurrentMethod() == 'getIndex')
                        <a href="{{ CRUDBooster::mainpath('import-data') }}" id='btn_import_data' data-url-parameter='{{$build_query}}' title='Import Data'
                           class="btn btn-sm btn-primary btn-import-data">
                            <i class="fa fa-download"></i> {{cbLang("button_import")}}
                        </a>
                    @endif

                <!-- END BUTTON -->
                </h1>


                <ol class="breadcrumb">
                    <li><a href="{{URL::to('eo')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li class="active">Event</li>
                </ol>
            @else
                
            @endif
        </section>
@endsection

@section('content')
<!-- Your custom  HTML goes here -->
<div class='panel panel-default' id="root">
    <div class="panel-body">
      <table class='table table-striped table-bordered datatables-simple'>
        <thead>
            <tr>
              <th>Event Name</th>
              <th>EO User Name</th>
              <th>Status</th>
              <th>Held</th>
              <th class="text-right">Action</th>
             </tr>
        </thead>
        <tbody>
          @foreach($event as $row)
            <tr>
              <td>{{$row->name}}</td>
              <td>{{$row->user_name}}</td>
              <td>
                  <span class="label label-{{($row->status=='Active')?'success':'default'}}">
                    {{$row->status}}
                  </span>
              </td>
              <td>
                @if ($row->date_end < date("Y-m-d")) 
                  <span class='label label-default'>Past</span>
                @elseif($row->date_end == date("Y-m-d"))
                  <span class='label label-success'>Today!</span>
                @else
                  <span class='label label-info'>Upcoming</span>
                @endif
              </td>
              <td class="text-right">
                  <a class='btn btn-xs btn-info' title="Go to event's dashboard" onclick='' href="{{URL::to('eo/dashboard_event/'.$row->id)}}" target='_blank'>
                    <i class='fa fa-dashboard'></i> Dashboard
                  </a>
                <a class='btn btn-xs btn-primary btn-detail' title='Detail Data' href='{{ route('event.show', $row->id) }}'>
                  <i class='fa fa-eye'></i>
                </a>
        
                <a class='btn btn-xs btn-success btn-edit' title='Edit Data' href="{{ route('event.edit', $row->id) }}">
                  <i class='fa fa-pencil'></i>
                </a>
                <a class='btn btn-xs btn-danger btn-delete' title='Delete' href='javascript:;' 
                  onclick="swal({   
                    title: 'Are you sure ?',   
                    text: 'You will not be able to recover this record data!',   
                    type: 'warning',   
                    showCancelButton: true,   
                    confirmButtonColor: '#ff0000',   
                    confirmButtonText: 'Yes!',  
                    cancelButtonText: 'No',  
                    closeOnConfirm: false 
                  }, 
                  function(){ 
                    location.href='{{URL::to('eo/event_delete/'.$row->id)}}' 
                  });">
                    <i class='fa fa-trash'></i>
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
</div>

@endsection