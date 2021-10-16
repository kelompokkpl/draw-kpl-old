<!-- First you need to extend the CB layout -->
@extends('event_organizer_template.eo_template')

@section('content-header')
        <section class="content-header">
            <h1> <i class='fa fa-envelope'></i> Mail to Winner &nbsp;&nbsp;

              <a href="{{URL::to('eo/dashboard_event/mails')}}" id='btn_show_data' class="btn btn-sm btn-primary" title="Show Data Event">
                  <i class="fa fa-table"></i> Show Data
              </a>

            </h1>
                <ol class="breadcrumb">
                    <li><a href="{{URL::to('eo/mails')}}"><i class="fa fa-bars"></i> Mail to Winner</a></li>
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
  <div class='panel-heading'><i class="fa fa-envelope"></i> Send an email to Winners</div>
    <div class="panel-body">
        <form method="POST" action="" id="form">
          @csrf
          <div class="col-sm-12">
          <div class='form-group header-group-0 ' id='form-group-name' style="">
            <label class='control-label col-sm-2'> Recipients
                <span class='text-danger' title='This field is required'>*</span>
            </label>
            <div class="col-sm-10">
              <select class="form-control" name="category_id" required>
                @foreach($category as $row)
                  <option value="{{$row->id}}">{{$row->name}}'s Winner</option>
                @endforeach
              </select>

              <div class="text-danger"></div>
              <p class='help-block'></p>
            </div>
          </div>    
          <div class='form-group form-datepicker header-group-0 ' id='form-group-date_start' style="">
            <label class='control-label col-sm-2'>Subject
              <span class='text-danger' title='This field is required'>*</span>
            </label>
            <div class="col-sm-10">
              <input type='text' title="Subject" required placeholder='Mail Subject' id="subject" maxlength=100 class='form-control' name="subject" />
              <div class="text-danger"></div>
              <p class='help-block'></p>
            </div>
          </div>

          <div class='form-group form-datepicker header-group-0 ' id='form-group-date_end' style="">
            <label class='control-label col-sm-2'>Content
              <span class='text-danger' title='This field is required'>*</span>
            </label>
            <div class="col-sm-10">
              <textarea id="editor" rows="5" name="content" required></textarea>
              <div class="text-danger"></div>
              <p class='help-block'></p>
            </div>
          </div>
          </div>
          <div class="col-md-2"></div>
          <div class="col-md-10">
            <br>&nbsp;
            <button type="submit" id="btn-submit" class="btn btn-success">Send</button>
          </div>
        </form>
    </div>
</div>
@endsection

@push('bottom')
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script type="text/javascript">
  CKEDITOR.replace( 'editor' );
  
  $('#btn-submit').on('click',function(e){
    e.preventDefault();
    var form = $(this).parents('form');
    let content = CKEDITOR.instances.editor.getData();
    let subject = $('#subject').val();

    if(content == '' || subject == ''){
        swal({
          title: "Whoops!",
          text: "You must fill subject and content!",
          type: "warning",
      });
      return false;
    } else{
      swal({
          title: "Are you sure?",
          text: "An email will be sent to all winners in this category. Make sure the content you share is correct",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#00D640",
          confirmButtonText: "Yes, send now!",
          closeOnConfirm: false
      }, function(isConfirm){
          if (isConfirm) form.submit();
      });
    }
  });
</script>
@endpush