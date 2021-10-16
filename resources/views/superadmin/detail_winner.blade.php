<!-- First, extends to the CRUDBooster Layout -->
@extends('crudbooster::admin_template')
@section('content')
  <!-- Your html goes here -->
  <div class='panel panel-default'>
    <div class='panel-heading'>Detail Winner</div>
    <div class='panel-body'>
      <div class="row">
        <div class='col-md-2'>
          <label>Category Name</label>
        </div>
        <div class='col-md-10'>
          : {{$row->category_name}}
        </div>
      </div>      
        
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
          <label>Participant Name</label>
        </div>
        <div class='col-md-10'>
          : {{$row->participant_name}}
        </div>
      </div>       
    </div>
  </div>
@endsection