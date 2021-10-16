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

class EOReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $data['page_title'] = 'EO Panel: Event Report';
        $data['event'] = DB::table('event')
            ->where('cms_users_id', Session::get('admin_id'))
            ->whereNull('deleted_at')
            ->get();
        return view('event_organizer.report.index', $data);
    }

    public function getDetail($event){
        $event = DB::table('event')
            ->leftJoin('cms_users', 'event.cms_users_id', '=', 'cms_users.id')
            ->leftJoin('category', 'event.id', 'category.event_id')
            ->select('event.*', 'cms_users.name as user_name')
            ->where('event.cms_users_id', Session::get('admin_id'))
            ->where('event.id', $event)
            ->whereNull('deleted_at')
            ->get();
        return json_encode($event);
    }

    public function printReport(Request $request){
        $data['event'] = DB::table('event')
            ->leftJoin('cms_users', 'event.cms_users_id', '=', 'cms_users.id')
            ->leftJoin('category', 'event.id', 'category.event_id')
            ->select('event.*', 'cms_users.name as user_name')
            ->where('event.cms_users_id', Session::get('admin_id'))
            ->where('event.id', $request->event_id)
            ->whereNull('deleted_at')
            ->first();
        $data['categories'] = DB::table('category')
            ->where('event_id', $request->event_id)
            ->select('id', 'name', 'is_draw', 'total_winner')
            ->orderBy('name')
            ->get();
        $data['winners'] = DB::table('winner')
                            ->rightJoin('category', 'category.id', 'winner.category_id')
                            ->where('category.event_id', $request->event_id)
                            ->leftJoin('participant', 'participant.id', 'winner.participant_id')
                            ->select('category.name as category_name', 'participant.participant_id as id', 'participant.name', 'participant.email')
                            ->orderBy('category_name')
                            ->get();

        // return view('event_organizer.report.print', $data); 
        $pdf = PDF::loadView('event_organizer.report.print', $data);  
        return $pdf->stream($data['event']->name.'.pdf', array('Attachment'=>false));
    }

}
