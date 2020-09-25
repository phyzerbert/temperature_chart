<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Employee;
use App\Temperature;

use Carbon\Carbon;

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
        $employee = Employee::orderBy('name')->first();
        
        return view('home', compact('start_date', 'end_date', 'employee'));
    }

    public function getChartData(Request $request) {
        $employee = Employee::find($request->get('employee_id'));
        $chart_start = Carbon::createFromFormat('Y-m-d', $request->get('start_date'));
        $chart_end = Carbon::createFromFormat('Y-m-d', $request->get('end_date'));
        
        $labels = $temperature_data = array();

        for ($dt=$chart_start; $dt <= $chart_end; $dt->addDay()) {
            $key = $dt->format('Y-m-d');
            $label = $dt->format('M/d');
            array_push($labels, $label);
            $daily_temperature = $employee->temperatures()->whereDate('datetime', $key)->avg('temperature');
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
        $date = $employee_id = '';
        if($request->get('date') != '') {
            $date = $request->get('date');
            $mod = $mod->whereDate('datetime', $date);
        }
        if($request->get('employee_id') != '') {
            $employee_id = $request->get('employee_id');
            $mod = $mod->where('employee_id', $employee_id);
        }
        $data = $mod->orderBy('datetime', 'desc')->paginate(15);
        return view('log', compact('data', 'date', 'employee_id'));
    }
}
