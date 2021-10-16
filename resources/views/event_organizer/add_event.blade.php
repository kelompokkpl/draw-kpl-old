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
                    <li class="active">Create</li>
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
    <div class="panel-body">
        <form method="POST" action="{{URL::to('eo/event')}}" id="form">
          @csrf
          <div class="col-sm-10">
          <div class='form-group header-group-0 ' id='form-group-name' style="">
            <label class='control-label col-sm-2'> Event Name
                <span class='text-danger' title='This field is required'>*</span>
            </label>
            <div class="col-sm-10">
              <input type='text' title="Name" required  placeholder='You can only enter the letter only'  maxlength=100 class='form-control' name="name" id="name" value=''/>

              <div class="text-danger"></div>
              <p class='help-block'></p>
            </div>
          </div>    
          <div class='form-group form-datepicker header-group-0 ' id='form-group-date_start' style="">
            <label class='control-label col-sm-2'>Date Start
              <span class='text-danger' title='This field is required'>*</span>
            </label>
            <div class="col-sm-4">
              <input type='date' title="Date Start" required class='form-control notfocus input_date' name="date_start" id="date_start" value='{{date("Y-m-d")}}'/>
              <div class="text-danger"></div>
              <p class='help-block'></p>
            </div>
          </div>

          <div class='form-group form-datepicker header-group-0 ' id='form-group-date_end' style="">
            <label class='control-label col-sm-2'>Date End
              <span class='text-danger' title='This field is required'>*</span>
            </label>
            <div class="col-sm-4">
              <input type='date' title="Date End" required class='form-control notfocus input_date' name="date_end" id="date_end" value='{{date("Y-m-d")}}'/>
              <div class="text-danger"></div>
              <p class='help-block'></p>
            </div>
          </div>
          </div>
          <div class="col-md-12">
            <br>
            <button type="reset" class="btn btn-danger">Reset</button>
            <button type="submit" class="btn btn-success">Save Data</button>
          </div>
        </form>
    </div>
</div>
@endsection