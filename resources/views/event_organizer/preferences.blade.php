@extends('event_organizer_template.eo_template')

@section('content')
<style type="text/css">
  .btn-preview{
    text-align: center;
    background-color: {{($event->button_background_color=='')?'#f8514c':$event->button_background_color}};
    color: {{($event->button_text_color=='')?'#ffffff':$event->button_text_color}};
    text-transform: uppercase;
    font-size: 1.5rem;
    font-family: MontserratBold;
    padding:0.8rem 2rem;
    border: 1px solid {{($event->button_border_color=='')?'#f8514c':$event->button_border_color}};
    outline: none;
    border-radius:.4rem;
    box-shadow: 0 7px 10px 0 {{($event->button_shadow_color=='')?'#f8514c':$event->button_shadow_color}};
    -webkit-box-shadow: 0 7px 10px 0 {{($event->button_shadow_color=='')?'#f8514c':$event->button_shadow_color}};
    -moz-box-shadow: 0 7px 10px 0 {{($event->button_shadow_color=='')?'#f8514c':$event->button_shadow_color}};
    cursor: pointer;
    -webkit-transition: .3s all ease-in-out;
    -o-transition: .3s all ease-in-out;
    transition: .3s all ease-in-out; 
    margin: 1rem;
  }
  input{
    margin-top: 6px!important;
  }
  .input-preview{
    width: 100px!important;
    display: inline-block;
  }
  .preview{
    margin-left: 2.5rem;
    font-family: Montserrat;
  }
  img{
    margin-top: 5px;
    width: 100%;
  }
  .required{
    color: red;
    font-weight: bold;
  }
</style>
  
  <!-- Your html goes here -->
  <div class='panel panel-default'>
    <div class='panel-heading'>Setting Preferences</div>

    <form method="POST" action="{{route('event.update', Session::get('event_id'))}}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class='panel-body' style="height:70%!important">
        <!-- Global Preferences -->
      <div class="col=col-md-12">
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#home">Global Preference</a></li>
          <li><a data-toggle="tab" href="#menu1">New Draw Page</a></li>
          <li><a data-toggle="tab" href="#menu2">Recent Draw Page</a></li>
          <li><a data-toggle="tab" href="#menu3">Draw History Page</a></li>
        </ul>

        <div class="tab-content">
          <div id="home" class="tab-pane fade in active">
            <div class="row">
              <div class="col-md-12">
                <h3>Global Preference</h3>
              </div>
              <div class='form-group col-md-2'>
                Global Text Color<span class="required">*</span><br>
                <input type='color' name='global_text_color' required class='form-control input-preview' value="{{($event->global_text_color=='')?'#333333':$event->global_text_color}}" id="global-text-color"/>
              </div>
              <div class='form-group col-md-2'>
                Line Color<span class="required">*</span><br>
                <input type='color' name='hr_color' required class='form-control input-preview' value="{{($event->hr_color=='')?'#333333':$event->hr_color}}" id="hr-color"/>
              </div>
            </div>
            <div class="row">
              <hr>
              <div class="col-md-4 text-center">
                <div class="text-left">Preview</div><br>
                <span id="preview-global-text-color" class="pb-0 text-montserrat-bold" style="color: {{($event->global_text_color=='')?'#333333':$event->global_text_color}};">Lorem Ipsum Dolor Sit Amet</span>
                <hr id="preview-hr-color" style="margin-top:5px; border-top: 3.5px solid {{($event->hr_color=='')?'#333333':$event->hr_color}}; width:20rem;">
              </div>
            </div>
          </div>

          <div id="menu1" class="tab-pane fade">
            <!-- New Draw Page -->
            <div class="row">
              <div class="col-md-12">
                <h3>New Draw Page</h3>
              </div>
              <div class="form-group col-md-4">
                Background Image
                <input type="file" name="background_new_draw" class="form-control" accept="image/*" id="background-new-draw">
                <i><small>If the image is not set, the image will be set to the default image</small></i>
              </div>
              <div class='form-group col-md-2'>
                Button Background Color<span class="required">*</span><br>
                <input type='color' name='button_background_color' required class='form-control input-preview' value="{{($event->button_background_color=='')?'#f8514c':$event->button_background_color}}" id="button-background-color"/>
              </div>
              <div class='form-group col-md-2'>
                Button Text Color<span class="required">*</span><br>
                <input type='color' name='button_text_color' required class='form-control input-preview' value="{{($event->button_text_color=='')?'#ffffff':$event->button_text_color}}" id="button-text-color"/>
              </div>
              <div class='form-group col-md-2'>
                Button Shadow Color<span class="required">*</span><br>
                <input type='color' name='button_shadow_color' required class='form-control input-preview' value="{{($event->button_shadow_color=='')?'#f8514c':$event->button_shadow_color}}" id="button-shadow-color"/>
              </div>
              <div class='form-group col-md-2'>
                Button Border Color<span class="required">*</span><br>
                <input type='color' name='button_border_color' required class='form-control input-preview' value="{{($event->button_border_color=='')?'#f8514c':$event->button_border_color}}" id="button-border-color"/>
              </div>
            </div>

            <!-- Preview New Draw Page -->
            <div class="row">
              <hr>
              <div class="col-md-4">
                Preview
                <img id="preview-background-new-draw" alt="Uploaded Image Preview Holder" src="{{($event->background_new_draw=='')?asset('assets/background/draw_background_first.png'):asset('assets/uploads/background'.'/'.$event->background_new_draw)}}">
              </div>
              <div class="col-md-8">
                Button Preview<br>
                <button class="btn-preview" id="preview-button">New Draw</button>
              </div>
            </div>
          </div>

          <div id="menu2" class="tab-pane fade">
            <!-- Recent Draw Page -->
            <div class="row">
              <div class="col-md-12">
                <h3>Recent Draw Page</h3>
              </div>
              <div class="form-group col-md-6">
                Background
                <input type="file" name="background_recent_draw" class="form-control" accept="image/*" id="background-recent-draw">
                <i><small>If the image is not set, the image will be set to the default image</small></i>
              </div>
              <div class='form-group col-md-6'>
                Button Draw Image
                <input type="file" name="button_image" class="form-control" accept="image/*" id="button-image">
                <i><small>If the image is not set, the image will be set to the default image</small></i>
              </div>
            </div>

            <!-- Preview Recent Draw Page -->
            <div class="row">
              <hr>
              <div class="col-md-4">
                Preview
                <img id="preview-background-recent-draw" alt="Uploaded Image Preview Holder" src="{{($event->background_recent_draw=='')?asset('assets/background/draw_background_process.png'):asset('assets/uploads/background'.'/'.$event->background_recent_draw)}}">
              </div>
              <div class="col-md-2"> </div>
              <div class="col-md-2">
                Button Image Preview<br>
                <img id="preview-buton-image" alt="Uploaded Image Preview Holder" src="{{($event->button_image=='')?asset('assets/image/img_draw_button.png'):asset('assets/uploads/button'.'/'.$event->button_image)}}">
              </div>
            </div>
          </div>

          <div id="menu3" class="tab-pane fade">
            <!-- Draw History Page -->
            <div class="row">
              <div class="col-md-12">
                <h3>Draw History Page</h3>
              </div>
              <div class="form-group col-md-6">
                Background
                <input type="file" name="background_draw_history" class="form-control" accept="image/*" id="background-draw-history">
                <i><small>If the image is not set, the image will be set to the default image</small></i>
              </div>
            </div>

            <!-- Preview Draw History Page -->
            <div class="row">
              <hr>
              <div class="col-md-4">
                Preview
                <img id="preview-background-draw-history" alt="Uploaded Image Preview Holder" src="{{($event->background_draw_history=='')?asset('assets/background/draw_background_process.png'):asset('assets/uploads/background'.'/'.$event->background_draw_history)}}">
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <div class='panel-footer'>
      <input type='submit' class='btn btn-primary' value='Save'/>
    </div>
  </form>
  </div>

@endsection