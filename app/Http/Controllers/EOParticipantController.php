<?php

namespace App\Http\Controllers;

use CRUDBooster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use App\Imports\ParticipantImport;
use Maatwebsite\Excel\Facades\Excel;
use Mail;

class EOParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'EO Panel: Participant';
        $data['participant'] = DB::table('participant')
                            ->where('event_id', Session::get('event_id'))
                            ->get();

        $can_part = DB::table('participant')
            ->where('event_id', Session::get('event_id'))
            ->count();
        Session::put('can_part', $can_part);

        return view('event_organizer.participant', $data);
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
            'phone' => 'regex:/[0-9]/', 
        ]);

        if($validatedData){
            unset($request['_token']);
            $request['created_at'] = date('Y-m-d H:i:s');
            $request['event_id'] = Session::get('event_id');
            DB::table('participant')->insert($request->all());

            $can_part = DB::table('participant')
                ->where('event_id', Session::get('event_id'))
                ->count();
            Session::put('can_part', $can_part);

            CRUDBooster::redirect(URL::to('eo/dashboard_event/participant'), "Yohoo! The participant has been added!", "info");
        }
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
        $validatedData = $request->validate([
            'phone' => 'regex:/[0-9]/', 
        ]);

        if($validatedData){
            unset($request['_token'], $request['_method']);
            $request['updated_at'] = date('Y-m-d H:i:s');
            DB::table('participant')->where('id', $id)->update($request->all());
            CRUDBooster::redirect(URL::to('eo/dashboard_event/participant'), "Good job! Participant data success updated!", "info");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!DB::table('participant')->where('id', $id)->exists()){
            CRUDBooster::redirect(URL::to('eo/dashboard_event/participant'), "Hey! Participant with id ".$id." is doesn't exist!","warning");
        }
        DB::table('participant')->where('id', $id)->delete();

        $can_part = DB::table('participant')
            ->where('event_id', Session::get('event_id'))
            ->count();
        Session::put('can_part', $can_part);

        CRUDBooster::redirect(URL::to('eo/dashboard_event/participant'), "Good job! The participant success deleted!", "info");
    }

    public function getImportView(){
        return view('event_organizer.import_participant');
    }

    public function import(Request $request){
        $validatedData = $request->validate([
            'participant' => 'required|max:5000'
        ]);
        if($validatedData){
            $extension = $request->participant->getClientOriginalExtension();
            if($extension == 'csv' || $extension == 'xls' || $extension == 'xlsx'){
                Excel::import(new ParticipantImport, request()->file('participant'));

                $can_part = DB::table('participant')
                    ->where('event_id', Session::get('event_id'))
                    ->count();
                Session::put('can_part', $can_part);
                
                CRUDBooster::redirect(URL::to('eo/dashboard_event/participant'), "Yohoo! The participant success imported!", "info");
            } else{
                CRUDBooster::redirect(URL::to('eo/dashboard_event/participant/import'), "Hmm! File type must be in .csv, .xls, .xlsx", "danger");
            }
        }
    }
}