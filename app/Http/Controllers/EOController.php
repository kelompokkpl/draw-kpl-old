<?php

namespace App\Http\Controllers;

use CRUDBooster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail;
use PDF;
use App\Imports\ParticipantImport;
use Maatwebsite\Excel\Facades\Excel;

class EOController extends Controller
{
    public function getLogin(){
        if(empty(Session::get('admin_id'))){
            return view('event_organizer.login');
        } else{
            return redirect()->route('indexEO');
        }
    }

    public function getIndex(){
        $data['past'] = DB::table('event')
                    ->where('cms_users_id', Session::get('admin_id'))
                    ->where('date_end', '<', date('Y-m-d'))
                    ->whereNull('deleted_at')
                    ->count();
        $data['event'] = DB::table('event')
                            ->where('cms_users_id', Session::get('admin_id'))
                            ->whereNull('deleted_at')
                            ->count();
        $data['upcoming'] = $data['event'] - $data['past'];
        $paid = DB::table('event')
                ->where('date_end', '>=', date('Y-m-d'))
                ->where('cms_users_id', Session::get('admin_id'))
                ->where('payment_status', 'Paid')
                ->whereNull('deleted_at')
                ->count();
        $unpaid = DB::table('event')
                ->where('date_end', '>=', date('Y-m-d'))
                ->where('payment_status', '<>', 'Paid')
                ->where('cms_users_id', Session::get('admin_id'))
                ->whereNull('deleted_at')
                ->count();
        $data['payment'] = ['paid' => $paid,
                            'unpaid' => $unpaid
                           ];
        $log = DB::select('SELECT log.url as path, log.event_id as event, COUNT(*) as y, CAST(log.created_at AS DATE) as date from log WHERE DATEDIFF(now(), STR_TO_DATE(created_at,"%Y-%m-%d")) <= 30 AND event_id <> "" AND cms_users_id = "'.Session::get('admin_id').'" GROUP BY date, path, event');
        
        $eventPerDay = DB::select('SELECT log.event_id as event, COUNT(*) as y, CAST(log.created_at AS DATE) as date from log WHERE DATEDIFF(now(), STR_TO_DATE(created_at,"%Y-%m-%d")) <= 30 AND event_id <> "" AND cms_users_id = "'.Session::get('admin_id').'" GROUP BY date, event ORDER BY event');
        foreach ($eventPerDay as $row) {
            $perDay[$row->event][$row->date] = $row->y;
        }
        foreach ($log as $row) {
            $perLog[$row->event][$row->date][] = [$row->path, $row->y];
        }

        $event = DB::table('event')
                    ->where('cms_users_id', Session::get('admin_id'))
                    ->whereNull('deleted_at')
                    ->select('id', 'name')
                    ->get();
        $date = array();

        for($i = 0; $i < 30; $i++){
            $date[] = date("Y-m-d", strtotime('-'. $i .' days'));
        }

        $data['date'] = array_reverse($date);
        
        $series = array();
        $k=0;
        foreach ($event as $row) {
            for($i = 0; $i < 30; $i++){
                if(!empty($perDay[$row->id][$data['date'][$i]])){
                    $y = $perDay[$row->id][$data['date'][$i]];
                } else{
                    $y = 0;
                }
                if(!empty($perLog[$row->id][$data['date'][$i]])){
                    // echo $row->id.'.'.$data['date'][$i].'<br>';
                    $drilldown[$k]['name'] = $row->name.'<br>'.$data['date'][$i];
                    $drilldown[$k]['type'] = 'column';
                    $drilldown[$k]['id'] = $row->id.$data['date'][$i];
                    $dataDrill = array();
                    for ($n=0; $n < count($perLog[$row->id][$data['date'][$i]]); $n++) { 
                        $dataDrill[] = [$perLog[$row->id][$data['date'][$i]][$n][0], $perLog[$row->id][$data['date'][$i]][$n][1]];   
                    }
                    
                    $drilldown[$k]['data'] = $dataDrill;
                    
                    $k++;

                    $datas[$i] = ['name'=>$data['date'][$i], 'y'=>$y, 'drilldown'=>$row->id.$data['date'][$i]];
                } else{
                    $datas[$i] = ['name'=>$data['date'][$i], 'y'=>$y];
                } 
            }
            $data['series'][] = ['name'=>$row->name, 'data'=>$datas]; 
        }
        $data['drilldown'] = $drilldown;

    	return view('event_organizer.index', $data);
    }

    public function getLockScreen(){
    	if (! CRUDBooster::myId()) {
            Session::flush();

            return redirect()->route('getLogin')->with('message', cbLang('alert_session_expired'));
        }

        Session::put('admin_lock', 1);
        return view('crudbooster::lockscreen');
    }

    public function getProfile(){
        $data['profile'] = DB::table('cms_users')
                            ->where('id', Session::get('admin_id'))
                            ->first();
        return view('event_organizer.profile', $data);
    }

    public function updateProfile(Request $request){
        unset($request['_token']);

        if($request->file('photo')!=''){
            $name = Str::random(10).'.'.$request->file('photo')->getClientOriginalExtension();
            $path = 'uploads/'.Session::get('admin_id').'/'.date('Y-m');
            $pathh = 'app/uploads/'.Session::get('admin_id').'/'.date('Y-m');
            $data['photo'] = $path.'/'.$name;
            $str = str_replace('\\', '/', URL::to(''));
            $request->file('photo')->move(storage_path($pathh), $name);
            Session::put('admin_photo', $str.'/'.$path.'/'.$name);
        }
        if($request->password!=''){
            $data['password'] = Hash::make($request->password);
        }

        $data['name'] = $request->name;
        $data['email'] = $request->email;

        DB::table('cms_users')->where('id', Session::get('admin_id'))->update($data);
        Session::put('admin_name', $request->name);
        CRUDBooster::redirect(URL::to('eo/profile'), "Hey! your profile success updated!","success");
    }

}