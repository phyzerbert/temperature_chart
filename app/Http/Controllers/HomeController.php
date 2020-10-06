<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Temperature;
use App\Setting;
use App\Notification;

use Carbon\Carbon;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $now = Carbon::now();
        $start_date = $now->startOfWeek()->format('Y-m-d');
        $end_date = $now->endOfWeek()->format('Y-m-d');
        if(Auth::user()->role == 'user') {
            $user = Auth::user();
        } else {
            $user = User::orderBy('name')->first();
        }

        return view('home', compact('start_date', 'end_date', 'user'));
    }

    public function getChartData(Request $request) {
        $user = User::find($request->get('user_id'));
        $chart_start = Carbon::createFromFormat('Y-m-d', $request->get('start_date'));
        $chart_end = Carbon::createFromFormat('Y-m-d', $request->get('end_date'));
        
        $labels = $temperature_data = array();

        for ($dt=$chart_start; $dt <= $chart_end; $dt->addDay()) {
            $key = $dt->format('Y-m-d');
            $label = $dt->format('M/d');
            array_push($labels, $label);
            $daily_temperature = $user->temperatures()->whereDate('datetime', $key)->avg('temperature');
            $daily_temperature = number_format($daily_temperature, 2);
            array_push($temperature_data, $daily_temperature);
        }

        $response_data = [
            'status' => 200,
            'labels' => $labels,
            'temperature_data' => $temperature_data,
        ];

        return response()->json($response_data);
    }

    public function logs(Request $request) {
        $mod = new Temperature();
        $users = User::where('role', 'user')->orderBy('name')->get();
        $period = $user_id = '';
        if($request->get('period') != '') {
            $period = $request->get('period');
            $from = substr($period, 0, 10);
            $to = substr($period, 14, 10);
            $mod = $mod->whereBetween('datetime', [$from, $to]);
        }
        if($request->get('user_id') != '') {
            $user_id = $request->get('user_id');
            $mod = $mod->where('user_id', $user_id);
        }
        $data = $mod->orderBy('datetime', 'desc')->paginate(15);
        return view('log', compact('data', 'users', 'period', 'user_id'));
    }

    public function setting(Request $request) {
        $setting = Setting::find(1);
        return view('setting', compact('setting'));
    }

    public function setting_update(Request $request) {
        $setting = Setting::find(1);
        $setting->update([
            'top_limit' => $request->get('top_limit'),
        ]);
        return back()->with('success', 'Updated Successfully!');
    }

    public function notification(Request $request) {
        $data = Notification::orderBy('created_at', 'desc')->paginate(15);
        return view('notification', compact('data'));
    }
}
