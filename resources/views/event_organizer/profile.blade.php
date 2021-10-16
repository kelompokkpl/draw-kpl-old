<!-- First you need to extend the CB layout -->
@extends('event_organizer_template.eo_template')

@section('content-header')
        <section class="content-header">
            <h1> <i class='fa fa-user'></i> Profile</h1>
                <ol class="breadcrumb">
                    <li><a href="{{URL::to('eo/')}}"><i class="fa fa-bars"></i> Dashboard</a></li>
                    <li class="active">Profile</li>
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
        <strong><i class='fa fa-users'></i> Profile</strong>
    </div>
    <div class="panel-body">
        <form method="POST" action="{{route('updateProfile')}}" id="form" enctype="multipart/form-data">
          @csrf
          <div class="col-sm-10 text-right">
          <div class='form-group header-group-0 ' id='form-group-name' style="">
            <label class='control-label col-sm-2'> Name
                <span class='text-danger' title='This field is required'>*</span>
            </label>
            <div class="col-sm-10">
              <input type='text' title="Name" required  placeholder='You can only enter the letter only'  maxlength=100 class='form-control' name="name" id="name" value='{{$profile->name}}'/>

              <div class="text-danger"></div>
              <p class='help-block'></p>
            </div>
          </div> 

          <div class='form-group header-group-0 ' id='form-group-name' style="">
            <label class='control-label col-sm-2'> Email
                <span class='text-danger' title='This field is required'>*</span>
            </label>
            <div class="col-sm-10">
              <input type='email' title="Email" required placeholder='example@email.com' maxlength=100 class='form-control' name="email" id="email" value='{{$profile->email}}'/>
              <div class="text-danger"></div>
              <p class='help-block'></p>
            </div>
          </div>  

          <div class='form-group header-group-0 ' id='form-group-name' style="">
            <label class='control-label col-sm-2'> Photo</label>
            <div class="col-sm-10">
              <input type="file" name="photo" class="form-control" accept="image/*" id="photo">
              <div class="text-danger"></div>
              <p class='help-block text-left'>Please leave empty if not change</p>
            </div>
          </div>   

          <div class='form-group header-group-0 ' id='form-group-name' style="">
            <label class='control-label col-sm-2'> Password</label>
            <div class="col-sm-10">
              <input type='password' title="Password" maxlength=100 class='form-control' name="password" id="password" />
              <div class="text-danger"></div>
              <p class='help-block text-left'>Please leave empty if not change</p>
            </div>
          </div>   

          <div class='form-group header-group-0 text-left' id='form-group-name' style="">
            <label class='control-label col-sm-2'> </label>
            <div class="col-sm-10">
              <button type="submit" class="btn btn-success">Save</button>
            </div>
          </div>      
          
          </div>
        </form>
    </div>
</div>
@endsection