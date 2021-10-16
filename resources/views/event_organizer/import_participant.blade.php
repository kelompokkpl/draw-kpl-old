<!-- First you need to extend the CB layout -->
@extends('event_organizer_template.eo_template')

@section('content-header')
        <section class="content-header">
            <h1> 
              <i class='fa fa-users'></i> Participant
               <a href="{{URL::to('eo/dashboard_event/participant')}}" id='btn_show_data' class="btn btn-sm btn-primary" title="Show Data Participant">
                  <i class="fa fa-table"></i> Show Data
              </a>

              <a href="" id='btn_add_data' class="btn btn-sm btn-success" title="Add Data Participant" data-toggle="modal" data-target="#participantCreate">
                  <i class="fa fa-plus-circle"></i> Add Data
              </a>
            </h1>
                <ol class="breadcrumb">
                    <li><a href="{{URL::to('eo/dashboard_event/participant')}}"><i class="fa fa-users"></i> Participant</a></li>
                    <li class="active">Import</li>
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
</style>

<div class='panel panel-default' id="root">
    <div class="panel-heading">
        <strong><i class='fa fa-users'></i> Import Participant</strong>
    </div>
    <div class="panel-body">
        <div class='callout callout-warning'>
          <h4>Welcome to Data Importer Tool</h4>
          Before doing upload a file, its better to read this bellow instructions : <br/>
          * File format should be : xls or xlsx or csv<br/>
          * If you have a big file data, we can't guarantee. So, please split those files into some parts of file (at least max 5 MB).<br/>
          * This tool is generate data automatically so, be carefull about your table xls structure. Please make sure correctly the table tructure.<br/>
          * Format : Format doesn't require heading column, so starting from the first row is containd your data. <br>
          * Table structure : 1st column is participant ID, 2nd column is name, 3rd column is email, 4th column is phone
        </div><br>
        <form method="POST" action="{{route('importParticipant')}}" id="form" enctype="multipart/form-data">
          @csrf
          <div class="col-sm-10">
          <div class='form-group header-group-0 ' id='form-group-name' style="">
            <label class='control-label col-sm-2'> File
                <span class='text-danger' title='This field is required'>*</span>
            </label>
            <div class="col-sm-10">
              <input type='file' title="Participant" required class='form-control' name="participant" id="participant" accept=".csv, .xls, .xlsx"/>
              <div class="text-danger"></div>
              <p class='help-block text-left'>File type supported only : XLS, XLSX, CSV</p>
            </div>
          </div> 

          <div class='form-group header-group-0 text-left' id='form-group-name' style="">
            <label class='control-label col-sm-2'> </label>
            <div class="col-sm-10">
              <button type="submit" class="btn btn-success" id="btn-submit">Import</button>
            </div>
          </div>      
          
          </div>
        </form>
    </div>
</div>

@endsection

@push('bottom')
<script type="text/javascript">
  $('#btn-submit').on('click',function(e){
    e.preventDefault();
    let participant = $('#participant').val();
    var form = $(this).parents('form');

    if(participant == '' || participant == null){
        swal({
          title: "Whoops!",
          text: "You must select an data!",
          type: "warning",
      });
      return false;
    } else{
        swal({
          title: "Are you sure?",
          text: "Data will imported to database, make sure correctly the table tructure!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#00D640",
          confirmButtonText: "Yes, import now!",
          closeOnConfirm: false
      }, function(isConfirm){
          if (isConfirm) form.submit();
      });
    }
  });
</script>
@endpush