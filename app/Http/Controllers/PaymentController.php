<?php

namespace App\Http\Controllers;

use PDF;
use CRUDBooster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'EO Panel: Payment';
        $data['event'] = DB::table('event')->where('cms_users_id', Session::get('admin_id'))
                                           ->whereNull('deleted_at')
                                           ->get();
        return view('event_organizer.payment', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('event_organizer.add_payment');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
                    'name' => 'required|max:100',
                    'nominal' => 'required',
                    'transfer_date' => 'required',
                    'photo' => 'required|mimes:jpg,jpeg,png,bmp'
                    ]);

        $path = 'assets/uploads/payment';
        if($request->file('photo')!=''){
            $data['photo'] = Str::random(10).'.'.$request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move(public_path($path), $data['photo']);
        }

        $data['name'] = $request->input('name');
        $data['transfer_date'] = $request->input('transfer_date');
        $data['nominal'] = $request->input('nominal');
        $data['event_id'] = $request->input('event_id');
        $data['status'] = 'Waiting for confirmation';
        $data['created_at'] = date('Y-m-d H:i:s');

        $insert = DB::table('payment')->insert($data);
        if($insert){
            DB::table('event')->where('id', $data['event_id'])->update(['payment_status' => 'Waiting for confirmation']);

            // Handle notification
            $receiver = DB::table('cms_users')->whereIn('id_cms_privileges', [1, 3])->pluck('id');
            $config['content'] = "[New Payment] has ben added!";
            // $config['content'] = "[New Payment] '".ucfirst(Session::get('event_name'))."' has ben added!";
            $config['to'] = CRUDBooster::adminPath('payment');
            $config['id_cms_users'] = $receiver; 
            CRUDBooster::sendNotification($config);

            //Redirect
            CRUDBooster::redirect(URL::to('eo/payment'), "Yohoo! The payment has been saved. Wait until Administrator confirm your payment, so your event will be active", "info");
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['page_title'] = 'EO Panel: Detail Payment';
        $data['event'] = DB::table('event')->where('code_invoice', $id)->first();
        $data['payment'] = DB::table('payment')
                            ->whereNull('deleted_at')
                            ->where('event_id', $data['event']->id)
                            ->orderBy('created_at','desc')
                            ->get();

        return view('event_organizer.detail_payment', $data);
    }

    public function cancelTransaction($id){
        DB::table('payment')->where('id', $id)->update(['status'=>'Canceled']);
        $payment = DB::table('payment')->where('id', $id)->select('event_id')->first();
        DB::table('event')->where('id', $payment->event_id)->update(['payment_status'=>'Unpaid']);

        CRUDBooster::redirect(URL::previous(), "Yohoo! The status of payment transaction has been changed.", "info");
    }

    public function printInvoice($id){
        $data['event'] = DB::table('event')
                            ->leftJoin('cms_users', 'event.cms_users_id', '=', 'cms_users.id')
                            ->select('event.*', 'cms_users.name as users_name', 'cms_users.email')
                            ->where('code_invoice', $id)
                            ->first();
        $data['payment'] = DB::table('payment')->where('event_id', $data['event']->id)->orderBy('created_at','desc')->get();
        
        $pdf = PDF::loadView('invoice.print', $data);  
        return $pdf->stream($id.'.pdf', array('Attachment'=>false));
    }

}
