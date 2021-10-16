<?php namespace App\Http\Controllers;

	use Session;
	use PDF;
	use DB;
	use CRUDBooster;	
	use Illuminate\Support\Str;
	use Illuminate\Support\Facades\URL;
	use Illuminate\Http\Request;

	class AdminPaymentController extends \crocodicstudio\crudbooster\controllers\CBController {

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
			$this->button_detail = false;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "payment";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Invoice Code","name"=>"event_id","join"=>"event,code_invoice"];
			$this->col[] = ["label"=>"Transfer Date","name"=>"transfer_date"];
			$this->col[] = ["label"=>"Event","name"=>"event_id","join"=>"event,name"];
			$this->col[] = ["label"=>"Name","name"=>"name"];
			$this->col[] = ["label"=>"Nominal","name"=>"nominal"];
			$this->col[] = ["label"=>"Status","name"=>"status"];
			$this->col[] = ["label"=>"Photo","name"=>"photo"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Event Name','name'=>'event_id','type'=>'select2','validation'=>'required|min:1|max:255','width'=>'col-sm-10','datatable'=>'event,name'];
			$this->form[] = ['label'=>'Name','name'=>'name','type'=>'text','validation'=>'required|string|min:3|max:100','width'=>'col-sm-10','placeholder'=>'You can only enter the letter only'];
			$this->form[] = ['label'=>'Transfer Date','name'=>'transfer_date','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Nominal','name'=>'nominal','type'=>'money','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Photo','name'=>'photo','type'=>'upload','validation'=>'required|image|mimes:jpg,jpeg,png,bmp|max:3000','width'=>'col-sm-10','help'=>'File types support : JPG, JPEG, PNG, BMP'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Event Name','name'=>'event_id','type'=>'select2','validation'=>'required|min:1|max:255','width'=>'col-sm-10','datatable'=>'event,name'];
			//$this->form[] = ['label'=>'Name','name'=>'name','type'=>'text','validation'=>'required|string|min:3|max:100','width'=>'col-sm-10','placeholder'=>'You can only enter the letter only'];
			//$this->form[] = ['label'=>'Transfer Date','name'=>'transfer_date','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Nominal','name'=>'nominal','type'=>'money','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Photo','name'=>'photo','type'=>'upload','validation'=>'required|mimes:jpg,jpeg,png,bmp|max:3000','width'=>'col-sm-10','help'=>'File types support : JPG, JPEG, PNG, BMP'];
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
			$this->addaction[] = ['label'=>'Confirm','url'=>CRUDBooster::mainpath('set-status/Confirmed/[id]'),'icon'=>'fa fa-check','color'=>'success','showIf'=>"[status] == 'Waiting for confirmation'", 'confirmation' => true];
			$this->addaction[] = ['label'=>'Reject','url'=>CRUDBooster::mainpath('set-status/Rejected/[id]'),'icon'=>'fa fa-ban','color'=>'danger','showIf'=>"[status] == 'Waiting for confirmation'", 'confirmation' => true];
			$this->addaction[] = ['url'=>CRUDBooster::mainpath('invoice/[id]'),'icon'=>'fa fa-print','color'=>'info','showIf'=>"[status] == 'Confirmed'", 'target'=>'_blank'];


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

	    public function getAdd() {
			//Create an Auth
			if(!CRUDBooster::isCreate() && $this->global_privilege==FALSE || $this->button_add==FALSE) { 
			    CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}
			  
			$data = [];
			$data['page_title'] = 'Add Data Payment';
			$data['event'] = DB::table('event')
							->orderby('name','asc')
							->where('payment_status', '<>', 'Paid')
							->where('payment_status', '<>', 'Waiting for confirmation')
							->whereNull('deleted_at')
							->get();
			  
			//Please use cbView method instead view method from laravel
			return view('superadmin.add_payment',$data);
		}

		public function getEdit($id) {
			//Create an Auth
			if(!CRUDBooster::isUpdate() && $this->global_privilege==FALSE || $this->button_edit==FALSE) {    
			    CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}
			  
			$data = [];
			$data['page_title'] = 'Edit Data';
			$data['payment'] = DB::table('payment')
							->leftJoin('event', 'event.id', '=', 'payment.event_id')
							->select('payment.*', 'event.name as event_name')
							->where('payment.id',$id)
							->first();
			$data['event'] = DB::table('event')
							->orderby('name','asc')
							->where('payment_status', '<>', 'Paid')
							->whereNull('deleted_at')
							->get();
			  
			return view('superadmin.edit_payment', $data);
		}

		public function savePayment(Request $request, $id=null){
	    	$validateData = $request->validate([
	            'name' => 'required',
	            'transfer_date' => 'required',
	            'nominal' => 'required',
	            'event_id' => 'required',
	            'photo' => 'mimes:jpg,jpeg,png,bmp'
	        ]);

	    	if($validateData){
	    		$path = 'assets/uploads/payment';
	    	
		    	if($request->file('photo')!=''){
		    		$data['photo'] = Str::random(10).'.'.$request->file('photo')->getClientOriginalExtension();
		    		$request->file('photo')->move(public_path($path), $data['photo']);
		    	}

		    	$data['name'] = $request->input('name');
		        $data['transfer_date'] = $request->input('transfer_date');
		        $data['nominal'] = $request->input('nominal');
		        $data['event_id'] = $request->input('event_id');

		        if($id==null){
		        	$data['status'] = 'Waiting for confirmation';
		        	$data['created_at'] = date('Y-m-d H:i:s');
		        	$insert = DB::table('payment')->insert($data);
			        if($insert){
			            DB::table('event')->where('id', $data['event_id'])->update(['payment_status' => 'Waiting for confirmation']);
			            CRUDBooster::redirect(CRUDBooster::mainpath(), "The payment has been saved !","info");
			        }	
		        } else{
		        	$data['updated_at'] = date('Y-m-d H:i:s');
		        	DB::table('payment')->where('id', $id)->update($data);
		        	CRUDBooster::redirect(CRUDBooster::mainpath(), "The payment has been updated !","info");
		        }
	    	}
	    }

	    public function getSetStatus($status,$id) {
			DB::table('payment')->where('id',$id)->update(['status'=>$status]);
			$event = DB::table('payment')->where('id',$id)->select('event_id')->first();

			if($status == 'Confirmed'){
				DB::table('event')->where('id',$event->event_id)->update(['payment_status'=>'Paid', 'status'=>'Active']);

				//Handle notification to EO page
				$data = DB::table('event')->where('id', $event->event_id)->select('event.name', 'event.cms_users_id')->first();
		        $config['content'] = "Hooray! Event '".ucfirst($data->name)."' has been activated!";
				$config['to'] = URL::to('eo/event');
				$config['id_cms_users'] = [$data->cms_users_id]; //This is an array of id users
				CRUDBooster::sendNotification($config);

				CRUDBooster::redirect($_SERVER['HTTP_REFERER'], "The payment status has been updated and event has been activated!", "info");
			}

			if($status == 'Rejected'){
				DB::table('event')->where('id',$event->event_id)->update(['payment_status'=>$status]);

				//Handle notification to EO page
				$data = DB::table('event')->where('id', $event->event_id)->select('event.name', 'event.cms_users_id')->first();
		        $config['content'] = "[Payment Rejected] Click here for detail!";
				$config['to'] = URL::to('eo/payment');
				$config['id_cms_users'] = [$data->cms_users_id]; //This is an array of id users
				CRUDBooster::sendNotification($config);

				CRUDBooster::redirect($_SERVER['HTTP_REFERER'], "The payment status has been updated!", "info");
			}
		   	
		}

		public function printInvoice($id){
	        $data['payment'] = DB::table('payment')->where('id', $id)->orderBy('created_at','desc')->get();
	        $data['event'] = DB::table('event')
                            ->leftJoin('cms_users', 'event.cms_users_id', '=', 'cms_users.id')
                            ->select('event.*', 'cms_users.name as users_name', 'cms_users.email')
                            ->where('event.id', $data['payment'][0]->event_id)
                            ->first();
	        
	        $pdf = PDF::loadView('invoice.print', $data);  
	        return $pdf->stream($data['event']->code_invoice.'.pdf', array('Attachment'=>false));
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
	        //Your code here
	            
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
	    	if($column_index == 2) {
				$column_value = date('F d, Y', strtotime($column_value));
			}	        
	    	if($column_index == 65) {
				switch($column_value) {
					case 'Unpaid':
				     	$column_value = "<i class='text-danger fa fa-circle'></i> ".$column_value;
					break;
					case 'Waiting for confirmation':
				     	$column_value = "<i class='text-warning fa fa-circle'></i> ".$column_value;
					break;
					case 'Paid':
				    	$column_value = "<i class='text-success fa fa-circle'></i> ".$column_value;
					break;
				}
			}
			if($column_index == 7) {
				$column_value = "<a data-lightbox='roadtrip'  rel='group_{payment}' title='Photo: Mahe' href='".asset('assets/uploads/payment'.'/'.$column_value)."'><img width='40px' height='40px' src='".asset('assets/uploads/payment'.'/'.$column_value)."'/></a>";
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
	        //Your code here

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
	        $payment = DB::table('payment')
	        		   ->select('event_id', 'status')
	        		   ->where('id', $id)
	        		   ->first();
	        if($payment->status=='Confirmed'){
	        	$data['status'] = 'Non Active';
	        }
	        $data['payment_status'] = 'Unpaid';
	        DB::table('event')->where('id', $payment->event_id)->update($data);
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


	}