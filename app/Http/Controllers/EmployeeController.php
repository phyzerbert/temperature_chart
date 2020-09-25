<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Employee;

class EmployeeController extends Controller
{
    public function getAll(Request $request) {
        $data = [
            'status' => 200,
            'data' => Employee::orderBy('name')->get(),
        ];
        return response()->json($data);
    }
}
