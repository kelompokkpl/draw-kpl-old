<!-- First you need to extend the CB layout -->
@extends('event_organizer_template.eo_template')

@section('content-header')
        <section class="content-header">
            <h1> <i class='fa fa-bars'></i> Participant &nbsp;&nbsp;

              <a href="{{URL::to('eo/dashboard_event/participant')}}" id='btn_show_data' class="btn btn-sm btn-primary" title="Show Data Participant">
                  <i class="fa fa-table"></i> Show Data
              </a>

              <a href="" id='btn_add_data' class="btn btn-sm btn-success" title="Add Data Participant" data-toggle="modal" data-target="#participantCreate">
                  <i class="fa fa-plus-circle"></i> Add Data
              </a>

              <a href="{{URL::to('eo/dashboard_event/participant/import')}}" class="btn btn-sm btn-success" title="Import Excel">
                  <i class="fa fa-download"></i> Import Excel
              </a>

            </h1>

              <!-- Modal Payment Create -->
                <div class="modal fade" id="participantCreate" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h3 class="modal-title">Create Participant</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form action="{{route('participant.store')}}" method="POST">
                        @csrf
                        <div class="modal-body">
                          <div class='form-group header-group-0 ' id='form-group-name' style="">
                            <label class='control-label col-sm-2'> ID
                                <span class='text-danger' title='This field is required'>*</span>
                            </label>
                            <div class="col-sm-10">
                              <input type='text' title="ID" required maxlength=100 class='form-control' name="participant_id" value=''/>
                              <div class="text-danger"></div>
                              <p class='help-block'></p>
                            </div>
                          </div>

                          <div class='form-group header-group-0 ' id='form-group-name' style="">
                            <label class='control-label col-sm-2'> Name
                                <span class='text-danger' title='This field is required'>*</span>
                            </label>
                            <div class="col-sm-10">
                              <input type='text' title="Name" required placeholder='You can enter the letter only'  maxlength=100 class='form-control' name="name" value=''/>
                              <div class="text-danger"></div>
                              <p class='help-block'></p>
                            </div>
                          </div>    

                          <div class='form-group header-group-0 ' style="">
                            <label class='control-label col-sm-2'>Email
                              <span class='text-danger' title='This field is required'>*</span>
                            </label>
                            <div class="col-sm-10">
                              <input type='email' title="Email" required class='form-control' placeholder='example@email.com' name="email"/>
                              <div class="text-danger"></div>
                              <p class='help-block'></p>
                            </div>
                          </div>

                          <div class='form-group header-group-0 ' id='form-group-name' style="">
                            <label class='control-label col-sm-2'> Phone</label>
                            <div class="col-sm-10">
                              <input type='text' title="Phone" maxlength='16' class='form-control' name="phone" value='' placeholder="Participant's phone number"/>
                              <div class="text-danger"></div>
                              <p class='help-block'></p>
                            </div>
                          </div>   
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-success">Save</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <ol class="breadcrumb">
                    <li><a href="{{URL::to('eo/dashboard_event'.'/'.Session::get('event_id'))}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li class="active">Participant</li>
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
              <th>ID</th>
              <th>Participant Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th class="text-right">Action</th>
             </tr>
        </thead>
        <tbody>
          @foreach($participant as $row)
            <tr>
              <td>{{$row->participant_id}}</td>
              <td>{{$row->name}}</td>
              <td>{{$row->email}}</td>
              <td>{{($row->phone=='')?'-':$row->phone}}</td>
              <td class="text-right">   
                <a class='btn btn-xs btn-success btn-edit' title='Edit Data' href="" data-toggle="modal" data-target="#participantEdit{{$row->id}}">
                  <i class='fa fa-pencil'></i>
                </a>
                <a class='btn btn-xs btn-danger btn-delete' title='Delete' href='javascript:;' 
                  onclick="swal({   
                    title: 'Are you sure ?',   
                    text: 'You will not be able to recover this record data!',   
                    type: 'warning',   
                    showCancelButton: true,   
                    confirmButtonColor: '#ff0000',   
                    confirmButtonText: 'Yes!',  
                    cancelButtonText: 'No',  
                    closeOnConfirm: false 
                  }, 
                  function(){ 
                    location.href='{{URL::to('eo/dashboard_event/participant_delete/'.$row->id)}}' 
                  });">
                    <i class='fa fa-trash'></i>
                </a>
              </td>

              <!-- Modal Payment Create -->
                <div class="modal fade" id="participantEdit{{$row->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h3 class="modal-title">Edit Participant</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form action="{{route('participant.update', $row->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                          <div class='form-group header-group-0 ' id='form-group-name' style="">
                            <label class='control-label col-sm-2'> ID
                                <span class='text-danger' title='This field is required'>*</span>
                            </label>
                            <div class="col-sm-10">
                              <input type='text' title="ID" required maxlength=100 class='form-control' name="participant_id" value='{{$row->participant_id}}'/>
                              <div class="text-danger"></div>
                              <p class='help-block'></p>
                            </div>
                          </div>

                          <div class='form-group header-group-0 ' id='form-group-name' style="">
                            <label class='control-label col-sm-2'> Name
                                <span class='text-danger' title='This field is required'>*</span>
                            </label>
                            <div class="col-sm-10">
                              <input type='text' title="Name" required placeholder='You can enter the letter only'  maxlength=100 class='form-control' name="name" value='{{$row->name}}'/>
                              <div class="text-danger"></div>
                              <p class='help-block'></p>
                            </div>
                          </div>    

                          <div class='form-group header-group-0 ' style="">
                            <label class='control-label col-sm-2'>Email
                              <span class='text-danger' title='This field is required'>*</span>
                            </label>
                            <div class="col-sm-10">
                              <input type='email' title="Email" required class='form-control' placeholder='example@email.com' name="email" value="{{$row->email}}" />
                              <div class="text-danger"></div>
                              <p class='help-block'></p>
                            </div>
                          </div>

                          <div class='form-group header-group-0 ' id='form-group-name' style="">
                            <label class='control-label col-sm-2'> Phone </label>
                            <div class="col-sm-10">
                              <input type='text' title="Phone" maxlength='16' class='form-control' name="phone" value='{{$row->phone}}' placeholder="Participant's phone number"/>
                              <div class="text-danger"></div>
                              <p class='help-block'></p>
                            </div>
                          </div>   
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