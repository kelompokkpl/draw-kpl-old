<?php namespace App\Http\Controllers;

	use Session;
	use DB;
	use CRUDBooster;
	use Illuminate\Http\Request;
	use Illuminate\Support\Str;
	use Illuminate\Support\Facades\URL;

	class AdminEventController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "name";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = true;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "event";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Name","name"=>"name"];
			$this->col[] = ["label"=>"EO name","name"=>"cms_users_id","join"=>"cms_users,name"];
			$this->col[] = ["label"=>"Payment Status","name"=>"payment_status"];
			$this->col[] = ["label"=>"Status","name"=>"status"];
			$this->col[] = ["label"=>"","name"=>"date_end"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'User','name'=>'cms_users_id','type'=>'select2','width'=>'col-sm-10','datatable'=>'cms_users,name','validation'=>'required'];
			$this->form[] = ['label'=>'Name','name'=>'name','type'=>'text','validation'=>'required|string|min:3|max:100','width'=>'col-sm-10','placeholder'=>'You can only enter the letter only'];
			$this->form[] = ['label'=>'Date Start','name'=>'date_start','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Date End','name'=>'date_end','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Payment Status','name'=>'payment_status','type'=>'hidden'];
			$this->form[] = ['label'=>'Status','name'=>'status','type'=>'hidden','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Code Invoice','name'=>'code_invoice','type'=>'hidden','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Cms Users Id','name'=>'cms_users_id','type'=>'hidden','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Name','name'=>'name','type'=>'text','validation'=>'required|string|min:3|max:100','width'=>'col-sm-10','placeholder'=>'You can only enter the letter only'];
			//$this->form[] = ['label'=>'Date Start','name'=>'date_start','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Date End','name'=>'date_end','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Payment Status','name'=>'payment_status','type'=>'radio','validation'=>'required|min:1|max:30','width'=>'col-sm-10','dataenum'=>'Free;Paid'];
			//$this->form[] = ['label'=>'Status','name'=>'status','type'=>'hidden','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Global Text Color','name'=>'global_text_color','type'=>'text','validation'=>'min:1|max:100','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Line Color','name'=>'hr_color','type'=>'text','validation'=>'min:1|max:100','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Background New Draw','name'=>'background_new_draw','type'=>'text','validation'=>'min:1|max:100','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Button Background Color','name'=>'button_background_color','type'=>'text','validation'=>'min:1|max:100','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Button Text Color','name'=>'button_text_color','type'=>'text','validation'=>'min:1|max:100','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Button Border Color','name'=>'button_border_color','type'=>'text','validation'=>'min:1|max:100','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Button Shadow Color','name'=>'button_shadow_color','type'=>'text','validation'=>'min:1|max:100','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Background Recent Draw','name'=>'background_recent_draw','type'=>'text','validation'=>'min:1|max:100','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Button Image','name'=>'button_image','type'=>'text','validation'=>'min:1|max:100','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Background Draw History','name'=>'background_draw_history','type'=>'text','validation'=>'min:1|max:100','width'=>'col-sm-10'];
			# OLD END FORM

			/* 
	        | ---------------------------------------------------------------------- 
	        | Sub Module
	        | ----------------------------------------------------------------------     
			| @label          = Label of action 
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class  
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        | 
	        */
	        $this->sub_module = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)     
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        | 
	        */
	        $this->addaction = array();
	        $this->addaction[] = ['label'=>'Set Active','url'=>CRUDBooster::mainpath('set-status/Active/[id]'),'icon'=>'fa fa-check','color'=>'success','showIf'=>"[status] == 'Non Active'", 'confirmation' => true];
			$this->addaction[] = ['label'=>'Set Non Active','url'=>CRUDBooster::mainpath('set-status/Non Active/[id]'),'icon'=>'fa fa-ban','color'=>'warning','showIf'=>"[status] == 'Active'", 'confirmation' => true];
			if(CRUDBooster::myPrivilegeId() != '3'){ // if the current privilege is not Administrator
				$this->addaction[] = ['url'=>CRUDBooster::mainpath('preferences/[id]'),'icon'=>'fa fa-gear','color'=>'info','title'=>'Setting Preference'];
			}


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Button Selected
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button 
	        | Then about the action, you should code at actionButtonSelected method 
	        | 
	        */
	        $this->button_selected = array();

	                
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------     
	        | @message = Text of message 
	        | @type    = warning,success,danger,info        
	        | 
	        */
	        $this->alert        = array();
	                

	        
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add more button to header button 
	        | ----------------------------------------------------------------------     
	        | @label = Name of button 
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        | 
	        */
	        $this->index_button = array();
	        


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------     
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.        
	        | 
	        */
	        $this->table_row_color = array();
			$this->table_row_color[] = ['condition'=>"[status] == 'Active'","color"=>"success"];      
			$this->table_row_color[] = ['condition'=>"[status] == 'Non Active'","color"=>"danger"];          

	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | You may use this bellow array to add statistic at dashboard 
	        | ---------------------------------------------------------------------- 
	        | @label, @count, @icon, @color 
	        |
	        */
	        $this->index_statistic = array();



	        /*
	        | ---------------------------------------------------------------------- 
	        | Add javascript at body 
	        | ---------------------------------------------------------------------- 
	        | javascript code in the variable 
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        $this->script_js = NULL;


            /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code before index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
	        $this->pre_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code after index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it after index table
	        | $this->post_index_html = "<p>test</p>";
	        |
	        */
	        $this->post_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include Javascript File 
	        | ---------------------------------------------------------------------- 
	        | URL of your javascript each array 
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
	        $this->load_js = array();
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Add css style at body 
	        | ---------------------------------------------------------------------- 
	        | css code in the variable 
	        | $this->style_css = ".style{....}";
	        |
	        */
	        $this->style_css = NULL;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include css File 
	        | ---------------------------------------------------------------------- 
	        | URL of your css each array 
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
	        $this->load_css = array();
	        
	        
	    }

	    public function getSetStatus($status,$id) {
			DB::table('event')->where('id',$id)->update(['status'=>$status]);

			if($status == 'Active'){
				//Handle notification to EO page
				$data = DB::table('event')->where('id', $id)->select('event.name', 'event.cms_users_id')->first();
		        $config['content'] = "Hooray! Event '".ucfirst($data->name)."' has been activated!";
				$config['to'] = URL::to('eo/event');
				$config['id_cms_users'] = [$data->cms_users_id]; //This is an array of id users
				CRUDBooster::sendNotification($config);
			}
		   
			//This will redirect back and gives a message
			CRUDBooster::redirect($_SERVER['HTTP_REFERER'],"The event status has been updated !","info");
		}

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for button selected
	    | ---------------------------------------------------------------------- 
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	    public function actionButtonSelected($id_selected,$button_name) {

	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	    public function hook_query_index(&$query) {
	        //Your code here
	            
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
			if($column_index == 3) {
				switch($column_value) {
					case 'Unpaid':
				     	$column_value = "<span class='label label-danger'>Unpaid</span>";
					break;
					case 'Waiting for confirmation':
				     	$column_value = "<span class='label label-warning'>".$column_value."</span>";
					break;
					case 'Paid':
				    	$column_value = "<span class='label label-success'>Paid</span>";
					break;
				}
			}

			if($column_index == 5) {
				if ($column_value <= date("Y-m-d")) {
					$column_value = "<span class='label label-danger'>Past</span>";
				} else{
					$column_value = "<span class='label label-success'>Upcoming</span>";
				}
			}
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before add data is execute
	    | ---------------------------------------------------------------------- 
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) { 
	        $code = date('Ym');
	        $event = DB::table('event')->select('code_invoice')->where('code_invoice', 'like', $code.'%')->orderBy('code_invoice', 'desc')->first();
	        if($event == null){
	            $code .= '0001';
	        } else{
	            $code .= str_pad(intval(substr($event->code_invoice, 7))+1, 4, '0', STR_PAD_LEFT);
	        }

	        $postdata['status'] = 'Non Active';
	        $postdata['payment_status'] = 'Unpaid';
	        $postdata['code_invoice'] = $code;
	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	    public function hook_after_add($id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before update data is execute
	    | ---------------------------------------------------------------------- 
	    | @postdata = input post data 
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_edit(&$postdata,$id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_edit($id) {
	        //Your code here 

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_delete($id) {
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_delete($id) {
	        //Your code here

	    }



	    //By the way, you can still create your own method in here... :) 

	    public function preferences($id) {
	    	if(!CRUDBooster::isCreate() && $this->global_privilege==FALSE) {    
			    CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}

	    	$data = [];
	    	$data['event'] = DB::table('event')->where('id', $id)->first();
	    	$data['page_title'] = ucfirst($data['event']->name);

	    	return view('superadmin.preferences', $data);
	    }

	    public function savePreferences(Request $request, $id) {
	    	$validated = $request->validate([
                'background_new_draw' => 'mimes:jpg,jpeg,png,bmp',
                'background_recent_draw' => 'mimes:jpg,jpeg,png,bmp',
                'background_draw_history' => 'mimes:jpg,jpeg,png,bmp', 
                'button_image' => 'mimes:jpg,jpeg,png,bmp',
                'global_text_color' => 'required',
	            'hr_color' => 'required',
	            'button_background_color' => 'required',
	            'button_text_color' => 'required',
	            'button_border_color' => 'required',
	            'button_shadow_color' => 'required'
            ]);

            if($validated){
            	$bg_path = 'assets/uploads/background';
		    	$btn_path = 'assets/uploads/button';

		    	if($request->file('background_new_draw')!=''){
		    		$data['background_new_draw'] = Str::random(10).'.'.$request->file('background_new_draw')->getClientOriginalExtension();
		    		$request->file('background_new_draw')->move(public_path($bg_path), $data['background_new_draw']);
		    	}
		    	if($request->file('background_recent_draw')!=''){
		    		$data['background_recent_draw'] = Str::random(10).'.'.$request->file('background_recent_draw')->getClientOriginalExtension();
		    		$request->file('background_recent_draw')->move(public_path($bg_path), $data['background_recent_draw']);
		    	}
		    	if($request->file('background_draw_history')!=''){
		    		$data['background_draw_history'] = Str::random(10).'.'.$request->file('background_draw_history')->getClientOriginalExtension();
		    		$request->file('background_draw_history')->move(public_path($bg_path), $data['background_draw_history']);
		    	}
		    	if($request->file('button_image')!=''){
		    		$data['button_image'] = Str::random(10).'.'.$request->file('button_image')->getClientOriginalExtension();
		    		$request->file('button_image')->move(public_path($btn_path), $data['button_image']);
		    	}

		    	$data['global_text_color'] = $request->input('global_text_color');
				$data['hr_color'] = $request->input('hr_color');
				$data['button_background_color'] = $request->input('button_background_color');
				$data['button_text_color'] = $request->input('button_text_color');
				$data['button_border_color'] = $request->input('button_border_color');
				$data['button_shadow_color'] = $request->input('button_shadow_color');

				DB::table('event')->where('id', $id)->update($data);
				CRUDBooster::redirect(URL::previous(),"The event preferences has been updated !","info");	
            }
	    }
	}