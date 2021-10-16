<?php

namespace App\Http\Controllers;

use CRUDBooster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class EOCategoryDisabledController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'EO Panel: Category Disabled';
        $data['category_disabled'] = DB::table('category_disabled')
                            ->leftJoin('category', 'category.id', '=', 'category_disabled.category_id')
                            ->leftJoin('participant', 'participant.id', '=', 'category_disabled.participant_id')
                            ->select('participant.name as participant_name', 'category.name as category_name', 'category_disabled.id')
                            ->where('category.event_id', Session::get('event_id'))
                            ->get();
        return view('event_organizer.category_disabled', $data);
    }

    public function addSelectedParticipant(){
        $data = [];
        $data['participant'] = DB::table('participant')
                                ->leftJoin('event','event.id','=','participant.event_id')
                                ->select('participant.*', 'event.id as event_id', 'event.name as event_name')
                                ->orderby('id','desc')
                                ->get();
        $data['category'] = DB::table('category')
                                ->where('event_id', Session::get('event_id'))
                                ->where('is_draw', 0)
                                ->orderby('name','asc')->get();

        return view('event_organizer.add_selected_participant', $data);
    }

    public function getCategory($id){
        $category = DB::table('category')
                        ->where('event_id', $id)
                        ->select('id', 'name', 'is_draw', 'total_winner')
                        ->get();
        return json_encode($category);
    }

    public function getParticipant($category){
        $participant = DB::table('participant')
                        ->leftJoin('event','event.id','=','participant.event_id')
                        ->select('participant.*', 'event.id as event_id', 'event.name as event_name')
                        ->where('event_id', Session::get('event_id'))
                        ->whereNotIn('participant.id', DB::table('category_disabled')
                            ->where('category_id', $category)
                            ->pluck('participant_id'))
                        ->get();
        return json_encode($participant);
    }

    public function saveDisabledCategory(Request $request){
        foreach ($request->input('selected_id') as $participant_id) {
            DB::table('category_disabled')
                ->insert([
                            'created_at' => date('Y-m-d H:i:s'),
                            'category_id' => $request->input('category_id'),
                            'participant_id' => $participant_id
                        ]);
        }
        
        CRUDBooster::redirect(URL::to('eo/dashboard_event/category_disabled'), "The Participant success add to disabled list !","info");
    }

    public function enableParticipant($id){
        if(!DB::table('category_disabled')->where('id', $id)->exists()){
            CRUDBooster::redirect(URL::to('eo/dashboard_event/category_disabled'), "Hey! data with id ".$id." is doesn't exist!","warning");
        }

        DB::table('category_disabled')->where('id', $id)->delete();
        CRUDBooster::redirect(URL::to('eo/dashboard_event/category_disabled'), "The Participant success add to enable list !","info");
    }
}