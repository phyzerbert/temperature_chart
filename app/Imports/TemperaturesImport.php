<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToArray;

use App\User;
use App\Temperature;
use App\Tfile;
use App\Setting;
use App\Notification;

use App\Events\DetectFever;

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
        $top_limit = Setting::find(1)->top_limit;
        array_shift($rows);
        foreach ($rows as $row) {
            $user = User::where('employee_id', intval($row[2]))->first();
            if(!$user) {
                $user = User::create([
                    'employee_id' => intval($row[2]),
                    'name' => trim($row[4], '"'),
                    'role' => 'user',
                ]);
            }
            $temperature = Temperature::create([
                'user_id' => $user->id,
                'datetime' => $row[1],
                'temperature' => $row[3]
            ]);

            if($row[3] > $top_limit) {
                $message = $user->name . " has a high fever of " . number_format($temperature->temperature, 2);
                $notification = Notification::create([
                    'user_id' => $user->id,
                    'temperature_id' => $temperature->id,
                    'message' => $message,
                ]);
                // event(new DetectFever($notification));
            }

        }

        Tfile::create(['path' => $this->file_path]);
        
    }
}
