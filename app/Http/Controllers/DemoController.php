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

class DemoController extends Controller
{
    public function getIndex(){
        return view('demo.index');
    }

    public function getNew(){
        return view('demo.new');

    }    

    public function getRecent(){
        if(empty($_GET['category']) && empty(Session::get('demo_category_id'))){
            $category = ['id'=>1, 'name'=>'This is Category One'];
        } else if(empty($_GET['category']) && !empty(Session::get('demo_category_id'))){
            if(Session::get('demo_category_id')==1){
                $category = ['id'=>1, 'name'=>'This is Category One'];
            }
            else if(Session::get('demo_category_id')==2){
                $category = ['id'=>2, 'name'=>"I'm Category Two"];
            } else{
                $category = ['id'=>3, 'name'=>"Category Three"];
            }
        } else if(!empty($_GET['category'])){
            if($_GET['category']==1){
                $category = ['id'=>1, 'name'=>'This is Category One'];
            }
            else if($_GET['category']==2){
                $category = ['id'=>2, 'name'=>"I'm Category Two"];
            } else{
                $category = ['id'=>3, 'name'=>"Category Three"];
            }
        }
        Session::put('demo_category_id', $category['id']);
        Session::put('demo_category_name', $category['name']);

        return view('demo.recent');
    }

    public function getDraw(){
        $part[0] = ['id'=>1, 'name'=>'Pearl', 'participant_id'=>'MH001'];
        $part[1] = ['id'=>2, 'name'=>'Haetea', 'participant_id'=>'MH002'];
        $part[2] = ['id'=>3, 'name'=>'John Doe', 'participant_id'=>'MH003'];
        $part[3] = ['id'=>4, 'name'=>'Bharlian', 'participant_id'=>'MH004'];
        $part[4] = ['id'=>1, 'name'=>'Kiky', 'participant_id'=>'MH005'];
        $part[5] = ['id'=>2, 'name'=>'Netty S', 'participant_id'=>'MH006'];
        $part[6] = ['id'=>3, 'name'=>'Maheru', 'participant_id'=>'MH007'];

        $candidates = [0,1,2,3,4,5,6];

        // Generate winners
        $total_winner[1] = 3;
        $total_winner[2] = 6;
        $total_winner[3] = 1;
        if(Session::get('demo_category_id')==3){
            $winners[0] = array_rand($candidates, $total_winner[Session::get('demo_category_id')]);
        } else{
            $winners = array_rand($candidates, $total_winner[Session::get('demo_category_id')]);
        }

        Session::put('demo_parts', $part);
        Session::put('demo_winners', $winners);
        $name = 'demo_history'.Session::get('demo_category_id');
        Session::put($name, $winners);

        return view('demo.drawing');
    }

    public function getWinner(){
        if(!Session::has('demo_winners')){
            CRUDBooster::redirect(URL::to('demo'), "","");
        }  else{
            $i = 0;
            if(count(Session::get('demo_winners'))){
                foreach (Session::get('demo_winners') as $row) {
                    $data['winner'][$i] = Session::get('demo_parts')[$row];
                    $i++; 
                }
            } else{
                $data['winner'][0] = Session::get('demo_parts')[Session::get('demo_winners')];
            }

            return view('demo.winner', $data);
        }
    }

    public function getHistory(){
        return view('demo.history');   
    }

    public function getWinnerByCategory($id){
        $data = array();
        if(Session::get('demo_history'.$id)!=''){
            if(count(Session::get('demo_history'.$id))){
                $i=0;
                foreach (Session::get('demo_history'.$id) as $row) {
                    $data[$i] = Session::get('demo_parts')[$row];
                    $i++; 
                }
            } else{
                $data[0] = Session::get('demo_parts')[Session::get('demo_winners')];
            }
        }
        return json_encode($data);
    }

    public function getWinners(){
        $data = array();
        return json_encode($data);
    }

}