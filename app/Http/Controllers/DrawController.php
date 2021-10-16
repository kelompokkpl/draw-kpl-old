<?php

namespace App\Http\Controllers;

use CRUDBooster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class DrawController extends Controller
{
    public function getIndex(){
        if(Session::get('event_active')!='Active'){
            CRUDBooster::redirect(URL::to('eo/dashboard_event'.'/'.Session::get('event_id')), "You not allowed to draw","warning");
        }
    	$data['event'] = DB::table('event')->where('id', Session::get('event_id'))->first();
    	$data['category'] = DB::table('category')
                            ->where('event_id', Session::get('event_id'))
                            ->where('is_draw', 0)
                            ->get();

    	return view('draw_layout.index', $data);

    }

    public function getNew(){
        $data['event'] = DB::table('event')->where('id', Session::get('event_id'))->first();
        $data['category'] = DB::table('category')
                            ->where('event_id', Session::get('event_id'))
                            ->where('is_draw', 0)
                            ->get();

        return view('draw_layout.new', $data);

    }    

    public function getRecent(){
        if(empty($_GET['category'])){
            $category = DB::table('category')->where('id', Session::get('category_id'))->first();
        } else{
            $category = DB::table('category')->where('id', $_GET['category'])->first();
        }
        Session::put('category_id', $category->id);
        Session::put('category_name', ucfirst($category->name));
        $data['event'] = DB::table('event')->where('id', Session::get('event_id'))->first();
        $data['category'] = DB::table('category')->where('event_id', Session::get('event_id'))->get();

        return view('draw_layout.recent', $data);
    }

    public function getDraw(){
        // If the category was drawn
        if(Session::get('is_draw')){ 
            DB::table('winner')->where('category_id', Session::get('category_id'))->delete();
        } 

        $part = DB::table('participant')
                                ->leftJoin('event','event.id','=','participant.event_id')
                                ->select('participant.id', 'participant.name', 'participant.participant_id')
                                ->where('event_id', Session::get('event_id'))
                                ->whereNotIn('participant.id', DB::table('category_disabled')
                                    ->where('category_id', Session::get('category_id'))
                                    ->pluck('participant_id'))
                                ->whereNotIn('participant.id', DB::table('winner')
                                    ->where('category_id', Session::get('category_id'))
                                    ->pluck('participant_id'))
                                ->get()->toArray();

	    $candidates_id = DB::table('participant')
	    					->where('event_id', Session::get('event_id'))
	    					->whereNotIn('participant.id', DB::table('category_disabled')
	    						->where('category_id', Session::get('category_id'))
	    						->pluck('participant_id'))
	    					->whereNotIn('participant.id', DB::table('winner')
	    						->where('category_id', Session::get('category_id'))
	    						->pluck('participant_id'))
	    					->pluck('id');

    	$data['event'] = DB::table('event')->where('id', Session::get('event_id'))->first();
    	$data['category'] = DB::table('category')->where('id', Session::get('category_id'))->first();

    	foreach ($candidates_id as $row) {
    		$candidates[$row] = $row;
    	}

    	// Generate winners
        if($data['category']->total_winner > count($part)){
            $total_winner = count($part);
        } else{
            $total_winner = $data['category']->total_winner;
        }
    	$winners = array_rand($candidates, $total_winner);

        if($data['category']->total_winner > 1){
            foreach ($winners as $row) {
                $winner[] = ['created_at'=>date('Y-m-d H:i:s'), 'participant_id'=>$row, 'category_id'=>Session::get('category_id')];
            }
        } else{
            $winners = [$winners];
            $winner = ['created_at'=>date('Y-m-d H:i:s'), 'participant_id'=>$winners[0], 'category_id'=>Session::get('category_id')];
        }

        Session::put('is_draw', 1);
        Session::put('parts', $part);
        Session::put('winners', $winners);
        
        DB::table('winner')->insert($winner);
        DB::table('category')->where('id', Session::get('category_id'))->update(['is_draw'=>1]);

        $can_draw = DB::table('category')
            ->where('event_id', Session::get('event_id'))
            ->where('is_draw', 0)
            ->count();
        Session::put('can_draw', $can_draw);

    	return view('draw_layout.drawing', $data);
    }

    public function getWinner(){
        if(!Session::has('winners')){
            CRUDBooster::redirect(URL::to('eo/dashboard_event/draw'), "","");
        }  else{
            $data['event'] = DB::table('event')->where('id', Session::get('event_id'))->first();
            if(count(Session::get('winners'))){
                $data['winner'] = DB::table('participant')->whereIn('id', Session::get('winners'))->get();   
            } else{
                $data['winner'] = DB::table('participant')->whereIn('id', Session::get('winners')[0])->get();
            }

            return view('draw_layout.winner', $data);
        }
    }

    public function getHistory(){
        $data['event'] = DB::table('event')->where('id', Session::get('event_id'))->first();
        $data['category'] = DB::table('category')
                            ->where('event_id', Session::get('event_id'))
                            ->orderBy('name')
                            ->get();

        return view('draw_layout.history', $data);   
    }

    public function getWinnerByCategory($id){
        $data = DB::table('winner')
                    ->where('category_id', $id)
                    ->leftJoin('participant', 'participant.id', 'winner.participant_id')
                    ->select('participant.name as name', 'winner.id', 'participant.participant_id')
                    ->get();
                    
        return json_encode($data);
    }
}