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
              <li class="active">Edit</li>
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
        <form method="POST" action="{{route('category.update', $category->id)}}" id="form">
          @csrf
          @method('PUT')
          <div class='form-group header-group-0 ' id='form-group-name' style="">
            <label class='control-label col-sm-2'> Category Name
                <span class='text-danger' title='This field is required'>*</span>
            </label>
            <div class="col-sm-10">
              <input type='text' title="Name" required placeholder='You can only enter the letter only'  maxlength=100 class='form-control' name="name" id="name" value='{{$category->name}}'/>

              <div class="text-danger"></div>
              <p class='help-block'></p>
            </div>
          </div>    
          <div class='form-group header-group-0 ' style="">
            <label class='control-label col-sm-2'>Total winner
              <span class='text-danger' title='This field is required'>*</span>
            </label>

            <div class="col-sm-10">
              <input type='number' title="Total Winner" required class='form-control' placeholder='You can only enter the number only' name="total_winner" value="{{$category->total_winner}}" />
              <div class="text-danger"></div>
              <p class='help-block'></p>
            </div>
          </div>
   
          <div class="col-md-12">
            <br>
            <button type="submit" class="btn btn-success">Save Data</button>
          </div>
        </form>
    </div>
</div>
@endsection