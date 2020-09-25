<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToArray;

use App\Employee;
use App\Temperature;
use App\Tfile;

class TemperaturesImport implements ToArray
{
    /**
    * @param Collection $collection
    */
    public $file_path;

    public function __construct($file_path) {
        $this->file_path = $file_path;
    }
    public function array(Array $rows)
    {   
        array_shift($rows);
        foreach ($rows as $row) {
            $employee = Employee::where('code', intval($row[2]))->first();
            if(!$employee) {
                $employee = Employee::create([
                    'code' => intval($row[2]),
                    'name' => trim($row[4], '"'),
                ]);
            }
            Temperature::create([
                'employee_id' => $employee->id,
                'datetime' => $row[1],
                'temperature' => $row[3]
            ]);
        }

        Tfile::create(['path' => $this->file_path]);
        
    }
}
