<!-- First, extends to the CRUDBooster Layout -->
@extends('crudbooster::admin_template')

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
  <!-- Your html goes here -->
  <div class='panel panel-default'>
    <div class='panel-heading'>Setting Preferences</div>

    <form method="POST" action="{{CRUDBooster::mainpath('save-preferences/'.$event->id)}}" enctype="multipart/form-data">
    @csrf
    <div class='panel-body'>
        <!-- Global Preferences -->
        <div class="row">
          <div class="col-md-12">
            <strong>Global Preferences</strong>
          </div>
          <div class='form-group col-md-2'>
            Global Text Color<span class="required">*</span><br>
            <input type='color' name='global_text_color' required class='form-control input-preview' value="{{($event->global_text_color=='')?'#333333':$event->global_text_color}}" id="global-text-color"/>
          </div>
          <div class='form-group col-md-2'>
            Line Color<span class="required">*</span><br>
            <input type='color' name='hr_color' required class='form-control input-preview' value="{{($event->hr_color=='')?'#333333':$event->hr_color}}" id="hr-color"/>
          </div>
          <div class="col-md-4 text-center">
            <div class="text-left">Preview</div><br>
            <span id="preview-global-text-color" class="pb-0 text-montserrat-bold" style="color: {{($event->global_text_color=='')?'#333333':$event->global_text_color}};">Lorem Ipsum Dolor Sit Amet</span>
            <hr id="preview-hr-color" style="margin-top:5px; border-top: 3.5px solid {{($event->hr_color=='')?'#333333':$event->hr_color}}; width:20rem;">
          </div>
        </div>

        <!-- New Draw Page -->
        <div class="row">
          <div class="col-md-12">
            <hr>
            <strong>New Draw Page</strong>
          </div>
          <div class="form-group col-md-4">
            Background Image
            <input type="file" name="background_new_draw" class="form-control" accept="image/*" id="background-new-draw">
            <i><small>If the image is not set, the image will be set to the default image</small></i>
          </div>
          <div class='form-group col-md-2'>
            Button Color<span class="required">*</span><br>
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
          <div class="col-md-4">
            Preview
            <img id="preview-background-new-draw" alt="Uploaded Image Preview Holder" src="{{($event->background_new_draw=='')?asset('assets/background/draw_background_first.png'):asset('assets/uploads/background'.'/'.$event->background_new_draw)}}">
          </div>
          <div class="col-md-8">
            Button Preview<br>
            <button class="btn-preview" id="preview-button">New Draw</button>
          </div>
        </div>

        <!-- Recent Draw Page -->
        <div class="row">
          <div class="col-md-12">
            <hr>
            <strong>Recent Draw Page</strong>
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

        <!-- Draw History Page -->
        <div class="row">
          <div class="col-md-12">
            <hr>
            <strong>Draw History Page</strong>
          </div>
          <div class="form-group col-md-6">
            Background
            <input type="file" name="background_draw_history" class="form-control" accept="image/*" id="background-draw-history">
            <i><small>If the image is not set, the image will be set to the default image</small></i>
          </div>
        </div>

        <!-- Preview Draw History Page -->
        <div class="row">
          <div class="col-md-4">
            Preview
            <img id="preview-background-draw-history" alt="Uploaded Image Preview Holder" src="{{($event->background_draw_history=='')?asset('assets/background/draw_background_process.png'):asset('assets/uploads/background'.'/'.$event->background_draw_history)}}">
          </div>
        </div>
    </div>
    <div class='panel-footer'>
      <input type='submit' class='btn btn-primary' value='Save'/>
    </div>
  </form>
  </div>
@endsection