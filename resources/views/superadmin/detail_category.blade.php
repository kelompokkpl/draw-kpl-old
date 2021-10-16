<!-- First, extends to the CRUDBooster Layout -->
@extends('crudbooster::admin_template')
@section('content')
  <!-- Your html goes here -->
  <div class='panel panel-default'>
    <div class='panel-heading'>Detail Category</div>
    <div class='panel-body'>
      <div class="row">
        <div class='col-md-2'>
          <label>Category Name</label>
        </div>
        <div class='col-md-10'>
          : {{$category->name}}
        </div>
      </div>      
        
      <div class="row">
        <div class='col-md-2'>
          <label>Event Name</label>
        </div>
        <div class='col-md-10'>
          : {{$category->event_name}}
        </div>
      </div>

      <div class="row">
         <div class='col-md-2'>
          <label>Total Winner</label>
        </div>
        <div class='col-md-10'>
          : {{$category->total_winner}}
        </div>
      </div>

      <div class="row">
         <div class='col-md-2'>
          <label>Status</label>
        </div>
        <div class='col-md-10'>
          : @if($category->is_draw == 0)
              <span class="label label-info">Belum Draw</span>
            @else
              <span class="label label-default">Sudah Draw</span>
            @endif
        </div>
      </div>
      <hr>

      <div class="col-md-12 mt-4">
        <label>Detail Winners</label>
        <table class="table table-bordered table-striped table-responsive datatables-simple">
          <thead>
            <tr>
              <th style="width:150px">ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($winner as $row)
              <tr>
                <td>{{$row->participant_id}}</td>
                <td>{{$row->name}}</td>
                <td>{{$row->email}}</td>
                <td>{{($row->phone == '')?'-':$row->phone}}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
        
      </form>
    </div>
  </div>
@endsection