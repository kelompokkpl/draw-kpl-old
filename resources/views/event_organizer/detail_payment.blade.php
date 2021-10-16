<!-- First you need to extend the CB layout -->
@extends('event_organizer_template.eo_template')

@section('content-header')
        <section class="content-header">
            <h1> <i class='fa fa-bars'></i> Payment &nbsp;&nbsp;

              <a href="{{URL::to('eo/payment')}}" id='btn_show_data' class="btn btn-sm btn-primary" title="Show Data">
                  <i class="fa fa-table"></i> Show Data
              </a>

            </h1>
                <ol class="breadcrumb">
                    <li><a href="{{URL::to('eo/payment')}}"><i class="fa fa-bars"></i> Payment</a></li>
                    <li class="active">Detail</li>
                </ol>
        </section>
@endsection
@section('content')
  <!-- Your html goes here -->
  <div class='panel panel-default'>
    <div class='panel-heading'>Detail Payment</div>
    <div class='panel-body'>
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
          <label>Invoice ID</label>
        </div>
        <div class='col-md-10'>
          : {{$event->code_invoice}}
        </div>
      </div>      

      <div class="row">
        <div class='col-md-2'>
          <label>Payment Status</label>
        </div>
        <div class='col-md-10'>
          : {{$event->payment_status}}
        </div>
      </div>

      <div class="row col-md-12">
        <br>
        <a href="{{route('printInvoice', $event->code_invoice)}}" class="btn btn-sm btn-info" target="_blank"><i class="fa fa-print"></i> Print Invoice</a>
        &nbsp;
        @if($event->payment_status=='Unpaid' || $event->payment_status=='Rejected')
          <a class="btn btn-sm btn-success" data-toggle="modal" data-target="#paymentCreate"><i class="fa fa-upload"></i> Upload</a>
        @else
          <a class="btn btn-sm btn-default"><i class="fa fa-upload"></i> Upload</a>
        @endif
      </div>
        <!-- Modal Payment Create -->
        <div class="modal fade" id="paymentCreate" tabindex="-1" role="dialog" aria-labelledby="paymentTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title">Create Payment</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="{{route('payment.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                  <div class='form-group header-group-0 ' id='form-group-name' style="">
                    <label class='control-label col-sm-2'> Name
                      <span class='text-danger' title='This field is required'>*</span>
                    </label>
                    <div class="col-sm-10">
                      <input type='text' title="Name" required placeholder='You can only enter the letter only'  maxlength=100 class='form-control' name="name" id="name" value=''/>
                      <div class="text-danger"></div>
                      <p class='help-block'></p>
                    </div>
                  </div>    

                  <div class='form-group header-group-0 ' style="">
                    <label class='control-label col-sm-2'>Nominal
                      <span class='text-danger' title='This field is required'>*</span>
                    </label>
                    <div class="col-sm-10">
                        <input type='number' title="Nominal" required class='form-control' placeholder='You can only enter the number only' name="nominal" value="100000" readonly />
                        <div class="text-danger"></div>
                        <p class='help-block'></p>
                    </div>
                  </div>

                  <div class='form-group header-group-0 ' style="">
                    <label class='control-label col-sm-2'>Transfer
                      <span class='text-danger' title='This field is required'>*</span>
                    </label>
                    <div class="col-sm-10">
                      <input type='date' title="Transfer Date" required class='form-control' name="transfer_date" value="{{date('Y-m-d')}}" />
                      <div class="text-danger"></div>
                      <p class='help-block'></p>
                    </div>
                  </div>

                  <div class='form-group header-group-0 ' style="">
                    <label class='control-label col-sm-2'>Photo
                      <span class='text-danger' title='This field is required'>*</span>
                    </label>
                    <div class="col-sm-10">
                      <input type='file' title="Photo" required class='form-control' name="photo" accept="image/*" />
                      <div class="text-danger"></div>
                      <p class='help-block'></p>
                    </div>
                  </div>
                  <input type="hidden" name="event_id" value="{{$event->id}}">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-success">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      <br>

      <div class="col-md-12 mt-4">
        <hr>
        <label>Detail Payment Transactions</label>
        <table class="table table-bordered table-striped table-responsive datatables-simple">
          <thead>
            <tr>
              <th style="width:150px">Transfer Date</th>
              <th>Name</th>
              <th>Nominal</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($payment as $row)
              <tr>
                <td>{{date('F d, Y', strtotime($row->transfer_date))}}</td>
                <td>{{$row->name}}</td>
                <td>{{$row->nominal}}</td>
                <td>{{$row->status}}</td>
                <td class="text-right"><a data-lightbox='roadtrip'  rel='group_payment' title='Photo' href="{{asset('assets/uploads/payment'.'/'.$row->photo)}}" class="btn btn-xs btn-icon btn-info"><i class="fa fa-image"></i></a> 
                @if($row->status == 'Waiting for confirmation')
                  <a class="btn btn-xs btn-icon btn-danger" href='javascript:;' 
                  onclick="swal({   
                    title: 'Cancel transaction?',   
                    text: 'Transaction will be canceled!',   
                    type: 'warning',   
                    showCancelButton: true,   
                    confirmButtonColor: '#ff0000',   
                    confirmButtonText: 'Yes!',  
                    cancelButtonText: 'No',  
                    closeOnConfirm: false 
                  }, 
                  function(){ 
                    location.href='{{URL::to('eo/payment/cancel/'.$row->id)}}' 
                  });"s><i class="fa fa-close"></i> Cancel transaction</a>
                @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      </form>
    </div>
  </div>
@endsection