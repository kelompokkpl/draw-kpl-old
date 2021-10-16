<!-- First you need to extend the CB layout -->
@extends('event_organizer_template.eo_template')

@section('content-header')
        <section class="content-header">
            <h1> <i class='fa fa-bars'></i> Add Category Disabled &nbsp;&nbsp;

              <a href="{{URL::to('eo/dahboard_event/category_disabled')}}" id='btn_show_data' class="btn btn-sm btn-primary" title="Show Data Event">
                  <i class="fa fa-table"></i> Show Data
              </a>

            </h1>
                <ol class="breadcrumb">
                    <li><a href="{{URL::to('eo/dashboard_event/category_disabled')}}"><i class="fa fa-bars"></i> Category Disabled</a></li>
                    <li class="active">Add Selected Participant</li>
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
        <form method="POST" action="{{route('save_disabled_category')}}" id="form">
          @csrf
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                Category<span class="required">*</span>
                <select name="category_id" class="form-control" v-model="category_selected" @change="categoryOnChange" required>
                  <option disabled value="">** Please select a category</option>
                  @foreach($category as $row)
                    <option value="{{$row->id}}">{{$row->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group"><br>
                <button type="submit" class="btn btn-success" v-if="participants.length" :disabled="isDisabled">Add Data</button>
              </div>
            </div>

          </div>
          <hr>

          @include('event_organizer.participant_data')

          <!-- ADD A PAGINATION -->
          <!-- <p>urldecode(str_replace("/?","?",$participant->appends(Request::all())->render()))</p> -->
      </form>
    </div>
</div>
@endsection

@prepend('bottom')
<script type="text/javascript">
    var basepath = {!! json_encode(URL::to('/eo')) !!};
    var page = 'category_disabled';
</script>

<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script src="https://unpkg.com/axios@0.20.0-0/dist/axios.min.js"></script>
<script src="{{ asset ('assets/js/eo_selected_participant.js')}}"></script>
@endprepend