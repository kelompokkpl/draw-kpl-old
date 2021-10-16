<?php

namespace App\Http\Controllers;

use CRUDBooster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use App\Jobs\SendEmailJob;

class EOMailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Session::get('event_id')==''){
            CRUDBooster::redirect(URL::to('eo/event'), "Hey! You must select an event to be able to access the dashboard","warning");
        }
        $data['page_title'] = Session::get('event_name').': Mail to Winner';
        $data['mail'] = DB::table('email')
                            ->leftJoin('category', 'category.id', '=', 'email.category_id')
                            ->where('category.event_id', Session::get('event_id'))
                            ->where('category.is_draw', 1)
                            ->select('email.*', 'category.name')
                            ->orderBy('email.id', 'desc')
                            ->get();
        return view('event_organizer.mail', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Session::get('event_id')==''){
            CRUDBooster::redirect(URL::to('eo/event'), "Hey! You must select an event to be able to access the dashboard","warning");
        }

        $data['page_title'] = Session::get('event_name').': Mail to Winner';
        $data['category'] = DB::table('category')
                                ->where('category.event_id', Session::get('event_id'))
                                ->where('category.is_draw', 1)
                                ->select('id', 'name')
                                ->orderBy('name')
                                ->get();
        return view('event_organizer.add_mail', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        unset($request['_token']);
        $validatedData = $request->validate([
            'category_id' => 'required',
            'subject' => 'required|max:100',
            'content' => 'required',
        ]);
        if($validatedData){
            $winners_email = DB::table('winner')
                                ->where('category_id', $request->category_id)
                                ->leftJoin('participant', 'participant.id', '=', 'winner.participant_id')
                                ->pluck('participant.email')->toArray();

            $details=[
                "event"=>Session::get('event_name'),
                "title"=>$request->subject,
                "body"=>$request->content,
                "first"=>$winners_email[0],
                "bcc"=>array_slice($winners_email, 1)
            ];
            
            dispatch(new SendEmailJob($details));
            $request['created_at'] = date('Y-m-d H:i:s');
            $insert = DB::table('email')->insert($request->all());
            
            CRUDBooster::redirect(URL::to('eo/dashboard_event/mails'), "Yippiee! Mails has been sent! It took a while to reach the recipient.", "info");
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
        if(Session::get('event_id')==''){
            CRUDBooster::redirect(URL::to('eo/event'), "Hey! You must select an event to be able to access the dashboard", "warning");
        }

        if(!DB::table('email')->where('id', $id)->exists()){
            CRUDBooster::redirect(URL::to('eo/dashboard_event/mails'), "Hey! email with id ".$id." is doesn't exist!", "warning");
        }
        $data['page_title'] = Session::get('event_name').': Detail Mails';
        $data['mail'] = DB::table('email')
                            ->leftJoin('category', 'category.id', '=', 'email.category_id')
                            ->select('email.*', 'category.name as name')
                            ->where('email.id', $id)
                            ->first();
        return view('event_organizer.detail_mail', $data);
    }
}