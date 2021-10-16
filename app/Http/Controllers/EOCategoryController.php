<?php

namespace App\Http\Controllers;

use CRUDBooster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class EOCategoryController extends Controller
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

        $data['page_title'] = Session::get('event_name').': Category';
        $data['category'] = DB::table('category')
                                ->where('category.event_id', Session::get('event_id'))
                                ->get();

        $can_draw = DB::table('category')
            ->where('event_id', Session::get('event_id'))
            ->where('is_draw', 0)
            ->count();
        Session::put('can_draw', $can_draw);

        return view('event_organizer.category', $data);
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

        $data['page_title'] = Session::get('event_name').': Category';
        return view('event_organizer.add_category', $data);
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
        $request['created_at'] = date('Y-m-d H:i:s');
        $insert = DB::table('category')->insert($request->all());

        $can_draw = DB::table('category')
            ->where('event_id', Session::get('event_id'))
            ->where('is_draw', 0)
            ->count();
        Session::put('can_draw', $can_draw);

        CRUDBooster::redirect(URL::to('eo/dashboard_event/category'), "Yohooo! The category has been added!", "info");
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

        if(!DB::table('category')->where('id', $id)->exists()){
            CRUDBooster::redirect(URL::to('eo/dashboard_event/category'), "Hey! category with id ".$id." is doesn't exist!", "warning");
        }
        $data['page_title'] = Session::get('event_name').': Detail Category';
        $data['category'] = DB::table('category')
                            ->leftJoin('winner', 'winner.category_id', 'category.id')
                            ->select('category.*', 'winner.created_at as draw_date')
                            ->where('category.id', $id)->first();
        $data['winner'] = DB::table('winner')
                            ->leftJoin('participant', 'participant.id', 'winner.participant_id')
                            ->leftJoin('category', 'category.id', '=', 'winner.category_id')
                            ->select('participant.*')
                            ->where('winner.category_id', $id)
                            ->get();
        return view('event_organizer.detail_category', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Session::get('event_id')==''){
            CRUDBooster::redirect(URL::to('eo/event'), "Hey! You must select an event to be able to access the dashboard", "warning");
        }

        if(!DB::table('category')->where('id', $id)->exists()){
            CRUDBooster::redirect(URL::to('eo/dashboard_event/category'), "Hey! Category with id ".$id." is doesn't exist!", "warning");
        }
        $data['page_title'] = Session::get('event_name').': Edit Category';
        $data['category'] = DB::table('category')->where('id', $id)->first();
        return view('event_organizer.edit_category', $data);
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
        unset($request['_token'], $request['_method']);
        DB::table('category')->where('id', $id)->update($request->all());
        CRUDBooster::redirect(URL::to('eo/dashboard_event/category'), "Good job! The category success updated!", "info");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   if(Session::get('event_id')==''){
            CRUDBooster::redirect(URL::to('eo/event'), "Hey! You must select an event to be able to access the dashboard", "warning");
        }
        if(!DB::table('category')->where('id', $id)->exists()){
            CRUDBooster::redirect(URL::to('eo/dashboard_event/category'), "Hey! Category with id ".$id." is doesn't exist!", "warning");
        }
        DB::table('category')->where('id', $id)->delete();

        $can_draw = DB::table('category')
            ->where('event_id', Session::get('event_id'))
            ->where('is_draw', 0)
            ->count();
        Session::put('can_draw', $can_draw);

        CRUDBooster::redirect(URL::to('eo/dashboard_event/category'),"Good job! The category success deleted!","info");
    }
}
