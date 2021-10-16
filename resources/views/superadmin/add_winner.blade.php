<!-- First you need to extend the CB layout -->
@extends('crudbooster::admin_template')
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
        <form method="POST" action="{{CRUDBooster::mainpath('save_winner')}}" id="form">
          @csrf
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                Event<span class="required">*</span>
                <select name="event_id" class="form-control" v-model="event_selected" @change="eventOnChange" required>
                  <option disabled value="">** Please select an event</option>
                  @foreach($event as $row)
                    <option value="{{$row->id}}">{{$row->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group" v-if="categories.length">
                Category<span class="required">*</span>
                <select name="category_id" class="form-control" v-model="category_selected" @change="categoryOnChange" required>
                    <option disabled value="">** Please select a category</option>
                    <option v-for="category in categories" v-bind:value="category.id">@{{category.name}}</option>
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

          @include('superadmin.participant_data')

      </form>
    </div>
</div>
@endsection

@prepend('bottom')
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script src="https://unpkg.com/axios@0.20.0-0/dist/axios.min.js"></script>

<script type="text/javascript">
  var basepath = {!! json_encode(URL::to('/admin')) !!};
  var page = 'winner';
</script>

<script src="{{ asset ('assets/js/selected_participant.js')}}"></script>
@endprepend