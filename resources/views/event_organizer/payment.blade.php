<!-- First you need to extend the CB layout -->
@extends('event_organizer_template.eo_template')

@section('content-header')

        <section class="content-header">
            <h1> <i class='fa fa-bars'></i> Payment &nbsp;&nbsp;

              <a href="{{URL::to('eo/payment')}}" id='btn_show_data' class="btn btn-sm btn-primary" title="Show Data Payment">
                  <i class="fa fa-table"></i> Show Data
              </a>

            </h1>

            <ol class="breadcrumb">
                <li><a href="{{URL::to('eo')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Payment</li>
            </ol>
        </section>
@endsection

@section('content')
<!-- Your custom  HTML goes here -->
<div class='panel panel-default' id="root">
    <div class="panel-body">
      <table class='table table-striped table-bordered datatables-simple'>
        <thead>
            <tr>
              <th>Invoice Code</th>
              <th>Event Name</th>
              <th>Payment Status</th>
              <th class="text-right">Action</th>
             </tr>
        </thead>
        <tbody>
          @foreach($event as $row)
            <tr>
              <td>{{$row->code_invoice}}</td>
              <td>{{$row->name}}</td>
              <td>
                  @if($row->payment_status=='Paid')
                    <span class="label label-success">{{$row->payment_status}}</span>
                  @elseif($row->payment_status=='Unpaid')
                    <span class="label label-danger">{{$row->payment_status}}</span>
                  @else
                    <span class="label label-warning">{{$row->payment_status}}</span>
                  @endif
              </td>
              <td class="text-right">
                @if($row->payment_status=='Unpaid' || $row->payment_status=='Rejected')
                  <a class='btn btn-xs btn-success' title='Upload' data-toggle="modal" data-target="#paymentCreate{{$row->id}}">
                    <i class='fa fa-upload'></i> Upload 
                  </a>
                @elseif($row->payment_status=='Paid')
                  <a class='btn btn-xs btn-default'>
                    <i class='fa fa-upload'></i> Upload 
                  </a>
                @else
                  <a class='btn btn-xs btn-default' data-toggle="tooltip" data-placement="top" title='Want to change the data? Please cancel payment first in payment detail'>
                    <i class='fa fa-upload'></i> Upload 
                  </a>
                @endif
                <a class='btn btn-xs btn-primary btn-detail' title='Detail Data' href='{{ route('payment.show', $row->code_invoice) }}'>
                  <i class='fa fa-eye'></i> Detail
                </a>
              </td>

              <!-- Modal Payment Create -->
                <div class="modal fade" id="paymentCreate{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="paymentTitle" aria-hidden="true">
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
                              <input type='text' title="Name" required placeholder='You can enter the letter only'  maxlength=100 class='form-control' name="name" id="name" value=''/>
                              <div class="text-danger"></div>
                              <p class='help-block'></p>
                            </div>
                          </div>    

                          <div class='form-group header-group-0 ' style="">
                            <label class='control-label col-sm-2'>Nominal
                              <span class='text-danger' title='This field is required'>*</span>
                            </label>
                            <div class="col-sm-10">
                              <input type='number' title="Nominal" required class='form-control' placeholder='You can enter the number only' name="nominal" value="100000" readonly="" />
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
                          <input type="hidden" name="event_id" value="{{$row->id}}">
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-success">Save</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
</div>

@endsection