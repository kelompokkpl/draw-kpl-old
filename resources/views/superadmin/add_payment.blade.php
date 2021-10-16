@extends('crudbooster::admin_template')
@section('content')
    <p><a title='Return' href="{{URL::to('admin/payment')}}"><i class='fa fa-chevron-circle-left '></i> &nbsp; Back To List Data Payment</a></p>
        
        @if ($errors->any())
            <div class='alert alert-danger'>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-danger"></i> Whoops!</h4>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="panel panel-default">
            <div class="panel-heading">
                <strong><i class='fa fa-money'></i> Add Payment</strong>
            </div>
            <div class="panel-body" style="padding:20px 0px 0px 0px">
                <form class='form-horizontal' method='post' id="form" enctype="multipart/form-data" action="{{CRUDBooster::mainpath('save_payment')}}">
                @csrf
                    <div class="box-body" id="parent-form-area">
                        <div class='form-group header-group-0 ' id='form-group-event_id' style="">
                        <label class='control-label col-sm-2'>Event Name
                            <span class='text-danger' title='This field is required'>*</span>
                        </label>

                    <div class="col-sm-10">
                        <select style='width:100%' class='form-control' id="event_id" required name="event_id">
                            <option value=''>** Please select a Event</option>
                            @foreach($event as $row)
                                <option value="{{$row->id}}"><b>{{$row->name}}</b>&nbsp; #{{$row->code_invoice}}</option>
                            @endforeach
                        </select>
        <div class="text-danger">
            
        </div><!--end-text-danger-->
        <p class='help-block'></p>

    </div>
</div>
    <div class='form-group header-group-0 ' id='form-group-name' style="">
    <label class='control-label col-sm-2'>
        Name
        <span class='text-danger' title='This field is required'>*</span>
    </label>

    <div class="col-sm-10">
        <input type='text' title="Name"
               required  placeholder='You can only enter the letter only'  maxlength=100 class='form-control'
               name="name" id="name" value=''/>

        <div class="text-danger"></div>
        <p class='help-block'></p>

    </div>
</div>    
<div class='form-group form-datepicker header-group-0 ' id='form-group-transfer_date'
     style="">
    <label class='control-label col-sm-2'>Transfer Date
        <span class='text-danger' title='This field is required'>*</span>
    </label>

    <div class="col-sm-10">
        <input type='date' title="Transfer Date" required class='form-control notfocus input_date' name="transfer_date" id="transfer_date" value='{{date('Y-m-d')}}'/>
        <div class="text-danger"></div>
        <p class='help-block'></p>
    </div>
</div>
    <div class="form-group header-group-0 " id="form-group-nominal" style="">
    <label class="control-label col-sm-2">Nominal
        <span class='text-danger' title='This field is required'>*</span>
    </label>

    <div class="col-sm-10">
        <input type="text" title="Nominal" required class="form-control inputMoney" name="nominal" id="nominal" value="" placeholder="You can enter the number only">
        <div class="text-danger"></div>
        <p class="help-block"></p>
    </div>
</div>
    <div class='form-group header-group-0 ' id='form-group-photo' style="">
    <label class='col-sm-2 control-label'>Photo
            <span class='text-danger' title='This field is required'>*</span>
    </label>

    <div class="col-sm-10">
        <input type='file' id="photo" title="Photo" required   class='form-control' name="photo"/ accept="image/*">
        <p class='help-block'>File types support : JPG, JPEG, PNG, BMP</p>
        <div class="text-danger"></div>
    </div>

</div>
                                            
</div><!-- /.box-body -->
<div class="box-footer" style="background: #F5F5F5">

    <div class="form-group">
        <label class="control-label col-sm-2"></label>
        <div class="col-sm-10">
            <a href="{{URL::to('admin/payment')}}" class='btn btn-default'>
                <i class='fa fa-chevron-circle-left'></i> Back
            </a>
            <input type="submit" name="submit" value='Save' class='btn btn-success'>
                                    
        </div>
    </div>
</div><!-- /.box-footer-->
</form>

</div>
</div>
@endsection