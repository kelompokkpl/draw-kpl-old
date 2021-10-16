<?php namespace crocodicstudio\crudbooster\controllers;

use CRUDBooster;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class AdminController extends CBController
{
    function getIndex()
    {
        if(Session::get('admin_privileges')==2){
            return redirect()->route('indexEO');
        } else{
            $data = [];
            $data['page_title'] = '<strong>Dashboard</strong>';
            $data['event'] = DB::table('event')->whereNull('deleted_at')->count(); 
            $data['transaction'] = DB::table('payment')->whereNull('deleted_at')->count();
            $data['payment'] = DB::table('payment')
                                ->leftJoin('event', 'event.id', 'payment.event_id')
                                ->whereNull('event.deleted_at')
                                ->whereNull('payment.deleted_at')
                                ->where('payment.status', 'Confirmed')
                                ->sum('payment.nominal');
            $paid = DB::table('event')
                    ->where('date_end', '>=', date('Y-m-d'))
                    ->where('payment_status', 'Paid')
                    ->whereNull('deleted_at')
                    ->count();
            $unpaid = DB::table('event')
                    ->where('date_end', '>=', date('Y-m-d'))
                    ->where('payment_status', '<>', 'Paid')
                    ->whereNull('deleted_at')
                    ->count();
            $data['pay_chart'] = ['paid' => $paid, 'unpaid' =>  $unpaid];

            // $userPerDay = DB::select('SELECT log.cms_users_id as user, COUNT(*) as y, CAST(log.created_at AS DATE) as date from log WHERE DATEDIFF(now(), STR_TO_DATE(created_at,"%Y-%m-%d")) <= 30 GROUP BY date, user ORDER BY user');
            // foreach ($userPerDay as $row) {
            //     $perDay[$row->user][$row->date] = $row->y;
            // }

            // $user = DB::table('cms_users')
            //             ->where('id_cms_privileges', 2)
            //             ->select('id', 'name')
            //             ->get();
            // $date = array();

            // for($i = 0; $i < 30; $i++){
            //     $date[] = date("Y-m-d", strtotime('-'. $i .' days'));
            // }


            // $data['date'] = array_reverse($date);
            
            // // dd($data['logData']);
            // $series = array();
            // foreach ($user as $row) {
            //     for($i = 0; $i < 30; $i++){
            //         if(!empty($perDay[$row->id][$data['date'][$i]])){
            //             $y = $perDay[$row->id][$data['date'][$i]];
            //         } else{
            //             $y = 0;
            //         }

            //         $datas[$i] = ['y'=>$y]; 
            //     }
            //     $data['series'][] = ['name'=>$row->name, 'data'=>$datas]; 
            // }

            $log = DB::select('SELECT log.url as path, log.event_id as event, COUNT(*) as y, CAST(log.created_at AS DATE) as date from log WHERE DATEDIFF(now(), STR_TO_DATE(created_at,"%Y-%m-%d")) <= 30 AND event_id <> "" GROUP BY date, path, event');
            // dd($log);
            $eventPerDay = DB::select('SELECT log.event_id as event, COUNT(*) as y, CAST(log.created_at AS DATE) as date from log WHERE DATEDIFF(now(), STR_TO_DATE(created_at,"%Y-%m-%d")) <= 30 AND event_id <> "" GROUP BY date, event ORDER BY event');
            foreach ($eventPerDay as $row) {
                $perDay[$row->event][$row->date] = $row->y;
            }
            foreach ($log as $row) {
                $perLog[$row->event][$row->date][] = [$row->path, $row->y];
            }

            $event = DB::table('event')
                        ->select('id', 'name')
                        ->whereNull('deleted_at')
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
                        $drilldown[$k]['name'] = $row->name.'<br>'.$data['date'][$i];
                        $drilldown[$k]['type']  = 'column';
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

            $data['income'] = DB::select("SELECT SUM(payment.nominal) as y, MONTH(transfer_date) as month FROM payment LEFT JOIN event ON event.id = payment.event_id WHERE ISNULL(event.deleted_at) AND payment.status = 'confirmed' AND ISNULL(payment.deleted_at) GROUP BY month ORDER BY month LIMIT 12");

            return view('dashboard.superadmin', $data);
        }
    }

    public function getLockscreen()
    {

        if (! CRUDBooster::myId()) {
            Session::flush();

            return redirect()->route('getLogin')->with('message', cbLang('alert_session_expired'));
        }

        Session::put('admin_lock', 1);

        return view('crudbooster::lockscreen');
    }

    public function postUnlockScreen()
    {
        $id = CRUDBooster::myId();
        $password = request('password');
        $users = DB::table(config('crudbooster.USER_TABLE'))->where('id', $id)->first();

        if (\Hash::check($password, $users->password)) {
            Session::put('admin_lock', 0);

            if(Session::get('admin_privileges')==2){
                return redirect(URL::to('eo'));
            } else{
                return redirect(CRUDBooster::adminPath());
            }
        } else {
            echo "<script>alert('".cbLang('alert_password_wrong')."');history.go(-1);</script>";
        }
    }

    public function getLogin()
    {

        if (CRUDBooster::myId()) {
            return redirect(CRUDBooster::adminPath());
        }

        return view('crudbooster::login');
    }

    public function postLogin()
    {

        $validator = Validator::make(Request::all(), [
            'email' => 'required|email|exists:'.config('crudbooster.USER_TABLE'),
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();

            return redirect()->back()->with(['message' => implode(', ', $message), 'message_type' => 'danger']);
        }

        $email = Request::input("email");
        $password = Request::input("password");
        $users = DB::table(config('crudbooster.USER_TABLE'))->where("email", $email)->first();

        if (\Hash::check($password, $users->password)) {
            $priv = DB::table("cms_privileges")->where("id", $users->id_cms_privileges)->first();

            $roles = DB::table('cms_privileges_roles')->where('id_cms_privileges', $users->id_cms_privileges)->join('cms_moduls', 'cms_moduls.id', '=', 'id_cms_moduls')->select('cms_moduls.name', 'cms_moduls.path', 'is_visible', 'is_create', 'is_read', 'is_edit', 'is_delete')->get();


            $photo = ($users->photo) ? asset($users->photo) : asset('vendor/crudbooster/avatar.jpg');
            Session::put('admin_id', $users->id);
            Session::put('admin_is_superadmin', $priv->is_superadmin);
            Session::put('admin_name', $users->name);
            Session::put('admin_photo', $photo);
            Session::put('admin_privileges_roles', $roles);
            Session::put("admin_privileges", $users->id_cms_privileges);
            Session::put('admin_privileges_name', $priv->name);
            Session::put('admin_lock', 0);
            Session::put('theme_color', $priv->theme_color);
            Session::put("appname", get_setting('appname'));

            CRUDBooster::insertLog(cbLang("log_login", ['email' => $users->email, 'ip' => Request::server('REMOTE_ADDR')]));

            $cb_hook_session = new \App\Http\Controllers\CBHook;
            $cb_hook_session->afterLogin();

            // Additional to handle EO privileg
            if ($priv->id == 2) {
                DB::table('log')->insert( [ 'created_at' => date('Y-m-d H:i:s'),
                                        'cms_users_id' => Session::get('admin_id'),
                                        'url' => 'eo/login'
                                        ]);
                return redirect('eo');
            }

            return redirect(CRUDBooster::adminPath());
        } else {

            if (!Str::contains(URL::previous(), 'admin')) {
                return redirect()->route('getLoginEO')->with('message', cbLang('alert_password_wrong'));
            }
            return redirect()->route('getLogin')->with('message', cbLang('alert_password_wrong'));
        }
    }

    public function getForgot()
    {
        if (CRUDBooster::myId()) {
            return redirect(CRUDBooster::adminPath());
        }

        return view('crudbooster::forgot');
    }

    public function postForgot()
    {
        $validator = Validator::make(Request::all(), [
            'email' => 'required|email|exists:'.config('crudbooster.USER_TABLE'),
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();

            return redirect()->back()->with(['message' => implode(', ', $message), 'message_type' => 'danger']);
        }

        $rand_string = str_random(5);
        $password = \Hash::make($rand_string);

        DB::table(config('crudbooster.USER_TABLE'))->where('email', Request::input('email'))->update(['password' => $password]);

        $appname = CRUDBooster::getSetting('appname');
        $user = CRUDBooster::first(config('crudbooster.USER_TABLE'), ['email' => g('email')]);
        $user->password = $rand_string;
        CRUDBooster::sendEmail(['to' => $user->email, 'data' => $user, 'template' => 'forgot_password_backend']);

        CRUDBooster::insertLog(cbLang("log_forgot", ['email' => g('email'), 'ip' => Request::server('REMOTE_ADDR')]));

        return redirect()->route('getLogin')->with('message', cbLang("message_forgot_password"));
    }

    public function getLogout()
    {

        $priv = Session::get("admin_privileges");
        if($priv==2){
            DB::table('log')->insert( [ 'created_at' => date('Y-m-d H:i:s'),
                                        'cms_users_id' => Session::get('admin_id'),
                                        'url' => 'eo/logout'
                                        ]);
        }
        $me = CRUDBooster::me();
        CRUDBooster::insertLog(cbLang("log_logout", ['email' => $me->email]));

        Session::flush();

        if($priv==2){
            return redirect()->route('getLoginEO')->with('message', cbLang("message_after_logout"));
        }
        return redirect()->route('getLogin')->with('message', cbLang("message_after_logout"));
    }
}