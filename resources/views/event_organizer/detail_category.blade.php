<!-- First you need to extend the CB layout -->
@extends('event_organizer_template.eo_template')

@section('content-header')
        <section class="content-header">
            <h1> <i class='fa fa-bars'></i> Category &nbsp;&nbsp;

              <a href="{{URL::to('eo/dashboard_event/category')}}" id='btn_show_data' class="btn btn-sm btn-primary" title="Show Data">
                  <i class="fa fa-table"></i> Show Data
              </a>

            </h1>
                <ol class="breadcrumb">
                    <li><a href="{{URL::to('eo/dashboard_event/category')}}"><i class="fa fa-bars"></i> Category</a></li>
                    <li class="active">Detail</li>
                </ol>
        </section>
@endsection
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
              <span class="label label-info">Hasn't been drawn</span>
            @else
              <span class="label label-default">Drawn!</span> (at {{date('F d, Y H:i', strtotime($category->draw_date))}})
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