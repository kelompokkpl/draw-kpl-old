<?php

namespace App\Http\Controllers;

use CRUDBooster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Mail;

class EOEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'EO Panel: Event';

        if(empty($_GET['held'])){
            $data['event'] = DB::table('event')
                ->leftJoin('cms_users', 'event.cms_users_id', '=', 'cms_users.id')
                ->select('event.*', 'cms_users.name as user_name')
                ->where('event.cms_users_id', Session::get('admin_id'))
                ->whereNull('deleted_at')
                ->get();
        } else{
            if($_GET['held']=='past'){
                $data['event'] = DB::table('event')
                    ->leftJoin('cms_users', 'event.cms_users_id', '=', 'cms_users.id')
                    ->select('event.*', 'cms_users.name as user_name')
                    ->where('event.cms_users_id', Session::get('admin_id'))
                    ->where('date_end', '<', date('Y-m-d'))
                    ->whereNull('deleted_at')
                    ->get();
            } elseif($_GET['held']=='upcoming'){
                $data['event'] = DB::table('event')
                    ->leftJoin('cms_users', 'event.cms_users_id', '=', 'cms_users.id')
                    ->select('event.*', 'cms_users.name as user_name')
                    ->where('event.cms_users_id', Session::get('admin_id'))
                    ->where('date_end', '>=', date('Y-m-d'))
                    ->whereNull('deleted_at')
                    ->get();
            } else{
                $data['event'] = DB::table('event')
                    ->leftJoin('cms_users', 'event.cms_users_id', '=', 'cms_users.id')
                    ->select('event.*', 'cms_users.name as user_name')
                    ->where('event.cms_users_id', Session::get('admin_id'))
                    ->whereNull('deleted_at')
                    ->get();
            }
        }

        return view('event_organizer.event', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('event_organizer.add_event');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'date_start' => 'required|after:yesterday', 
            'date_end' => 'required|after_or_equal:date_start', 
        ]);

        if($validatedData){
            $code = date('Ym');
            $event = DB::table('event')->select('code_invoice')->where('code_invoice', 'like', $code.'%')->orderBy('code_invoice', 'desc')->first();
            if($event == null){
                $code .= '0001';
            } else{
                $code .= str_pad(intval(substr($event->code_invoice, 7))+1, 4, '0', STR_PAD_LEFT);
            }
            
            unset($request['_token']);
            $request['created_at'] = date('Y-m-d H:i:s');
            $request['code_invoice'] = $code;
            $request['payment_status'] = 'Unpaid';
            $request['status'] = 'Non Active';
            $request['cms_users_id'] = Session::get("admin_id");

            if(DB::table('event')->insert($request->all())){
                // Handle notification
                $receiver = DB::table('cms_users')->whereIn('id_cms_privileges', [1, 3])->pluck('id');
                $config['content'] = "[New Event] '".ucfirst($request->name)."' has ben added!";
                $config['to'] = CRUDBooster::adminPath('event');
                $config['id_cms_users'] = $receiver; 
                CRUDBooster::sendNotification($config);

                // Send invoice email 
                $user = Db::table('cms_users')->where('id', Session::get('admin_id'))->select('email')->first();
                $data['email'] = $user->email;
                $data['name'] = Session::get('admin_name');
                $data['code'] = $code;
                $data['date'] = date('F d, Y');
                $data['due'] = date('F d, Y', strtotime("+1 week"));
                $data['event_name'] = $request->input('name');

                $mail = str_replace("\xE2\x80\x8B", "", $user->email);

                Mail::send('mail.invoice', $data, function($message) use ($mail){
                    $message->to($mail, Session::get('admin_name'))
                            ->subject('Invoice from Draw System');
                    $message->from('draw.eventy@gmail.com', 'Draw System');

                });

                if (Mail::failures()) {
                    CRUDBooster::redirect(URL::to('eo/event'), "The event has been added! But failed when sending email about payment info. Contact administrator for payment info", "warning");
                } 
                CRUDBooster::redirect(URL::to('eo/event'), "The event has been added! Please check your email to get the payment info", "info");

            }
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
        if(!DB::table('event')->where('cms_users_id',Session::get('admin_id'))->where('id', $id)->exists()){
            CRUDBooster::redirect(URL::to('eo/event'), "Hey! Event with id ".$id." is doesn't exist!","warning");
        }
        $data['page_title'] = 'EO Panel: Detail Event';
        $data['event'] = DB::table('event')->where('id', $id)->first();
        return view('event_organizer.detail_event', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!DB::table('event')->where('cms_users_id',Session::get('admin_id'))->where('id', $id)->exists()){
            CRUDBooster::redirect(URL::to('eo/event'), "Hey! Event with id ".$id." is doesn't exist!","warning");
        }

        $data['page_title'] = 'EO Panel: Edit Event';
        $data['event'] = DB::table('event')->where('id', $id)->first();
        return view('event_organizer.edit_event', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Str::contains(URL::previous(), 'edit')){
            $validatedData = $request->validate([
                'date_start' => 'required', 
                'date_end' => 'required|after_or_equal:date_start', 
            ]);

            if($validatedData){
                unset($request['_token'], $request['_method']);
                DB::table('event')->where('id', $id)->update($request->all());
            }
        } else {
            // $validated = $request->validate([
            //     'background_new_draw' => 'mimes:jpg,jpeg,png,bmp',
            //     'background_recent_draw' => 'mimes:jpg,jpeg,png,bmp',
            //     'background_draw_history' => 'mimes:jpg,jpeg,png,bmp', 
            //     'button_image' => 'mimes:jpg,jpeg,png,bmp'
            // ]);

            // if($validated){
                $bg_path = 'assets/uploads/background';
                $btn_path = 'assets/uploads/button';

                if($request->file('background_new_draw')!=''){
                    $validated = $request->validate([
                        'background_new_draw' => 'mimes:jpg,jpeg,png,bmp'
                    ]);
                    if($validated){
                        $data['background_new_draw'] = Str::random(10).'.'.$request->file('background_new_draw')->getClientOriginalExtension();
                        $request->file('background_new_draw')->move(public_path($bg_path), $data['background_new_draw']);
                    }
                }
                if($request->file('background_recent_draw')!=''){
                    $validated = $request->validate([
                        'background_recent_draw' => 'mimes:jpg,jpeg,png,bmp'
                    ]);
                    if($validated){
                        $data['background_recent_draw'] = Str::random(10).'.'.$request->file('background_recent_draw')->getClientOriginalExtension();
                        $request->file('background_recent_draw')->move(public_path($bg_path), $data['background_recent_draw']);
                    }
                }
                if($request->file('background_draw_history')!=''){
                    $validated = $request->validate([
                        'background_draw_history' => 'mimes:jpg,jpeg,png,bmp'
                    ]);
                    if($validated){
                        $data['background_draw_history'] = Str::random(10).'.'.$request->file('background_draw_history')->getClientOriginalExtension();
                        $request->file('background_draw_history')->move(public_path($bg_path), $data['background_draw_history']);
                    }
                }
                if($request->file('button_image')!=''){
                    $validated = $request->validate([
                        'button_image' => 'mimes:jpg,jpeg,png,bmp'
                    ]);
                    if($validated){
                        $data['button_image'] = Str::random(10).'.'.$request->file('button_image')->getClientOriginalExtension();
                        $request->file('button_image')->move(public_path($btn_path), $data['button_image']);
                    }
                }

                $data['global_text_color'] = $request->input('global_text_color');
                $data['hr_color'] = $request->input('hr_color');
                $data['button_background_color'] = $request->input('button_background_color');
                $data['button_text_color'] = $request->input('button_text_color');
                $data['button_border_color'] = $request->input('button_border_color');
                $data['button_shadow_color'] = $request->input('button_shadow_color');

                DB::table('event')->where('id', $id)->update($data);
            // }
        }
        if(Str::contains(URL::previous(), 'dashboard_event/preferences')){
            CRUDBooster::redirect(URL::previous(),"Good job! The preferences success updated!","info");
        }
        CRUDBooster::redirect(URL::to('eo/event'),"Good job! The event success updated!","info");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!DB::table('event')->where('cms_users_id',Session::get('admin_id'))->where('id', $id)->exists()){
            CRUDBooster::redirect(URL::to('eo/event'), "Hey! Event with id ".$id." is doesn't exist!","warning");
        }
        DB::table('event')->where('id', $id)->update(['deleted_at'=>date('Y-m-d H:i:s')]);
        DB::table('payment')->where('event_id', $id)->update(['deleted_at'=>date('Y-m-d H:i:s')]);
        CRUDBooster::redirect(URL::to('eo/event'),"Good job! The event success deleted!","info");
    }

    public function dashboard($id)
    {
        if(!DB::table('event')->where('id', $id)->where('cms_users_id',Session::get('admin_id'))->exists()){
            CRUDBooster::redirect(URL::to('eo/event'), "Hey! Event with id ".$id." is doesn't exist or not active","warning");
        }

        $data['event'] = DB::table('event')->where('id', $id)->first();
        $data['participant'] = DB::table('participant')->where('event_id', $id)->get();
        $data['page_title'] = 'Dashboard '.$data['event']->name;

        $data['past'] = DB::table('event')
                            ->where('cms_users_id', Session::get('admin_id'))
                            ->where('date_end', '>', date('Y-m-d'))
                            ->count();
        $data['category'] = DB::table('category')
                            ->where('event_id', $id)
                            ->count();
        $can_draw = DB::table('category')
                            ->where('event_id', $id)
                            ->where('is_draw', 0)
                            ->count();
        $data['participant'] = DB::table('participant')
                            ->where('event_id', $id)
                            ->count();
        $data['winner'] = DB::table('category')
                            ->where('category.event_id', $id)
                            ->sum('total_winner');
        $data['cat'] = DB::table('category')
                            ->leftJoin('event', 'event.id', 'category.event_id')
                            ->where('category.event_id', $id)
                            ->select('category.name', 'category.id')
                            ->orderBy('category.name')
                            ->get();
        $data['win'] = DB::table('winner')
                            ->leftJoin('category', 'category.id', 'winner.category_id')
                            ->where('category.event_id', $id)
                            ->leftJoin('participant', 'participant.id', 'winner.participant_id')
                            ->select('category.id as category_id', 'participant.participant_id as id', 'participant.name', 'participant.email')
                            ->orderBy('category_id')
                            ->get();
        $data['winners'] = DB::table('winner')
                            ->leftJoin('category', 'category.id', 'winner.category_id')
                            ->leftJoin('participant', 'participant.id', 'winner.participant_id')
                            ->where('category.event_id', $id)
                            ->select('participant.name as name', DB::raw('COUNT(*) as weight'))
                            ->groupBy('participant.name')
                            ->get();
                    
        Session::put('event_id', $id);
        Session::put('event_name', $data['event']->name);
        Session::put('event_active', $data['event']->status);
        Session::put('can_draw', $can_draw);
        Session::put('can_part', $data['participant']);
        return view('event_organizer.event_dashboard', $data);
    }

    public function getPreferences(){
        if(Session::get('event_id')==''){
            CRUDBooster::redirect(URL::to('eo/event'), "Hey! You must select an event to be able to access the dashboard","warning");
        }
        $data['page_title'] = ucfirst(Session::get('event_name')).': Preferences';
        $data['event'] = DB::table('event')->where('id', Session::get('event_id'))->first();
        return view('event_organizer.preferences', $data);
    }
}
