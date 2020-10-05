<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToArray;

use App\User;

class LenelImport implements ToArray
{
    public function array(Array $rows)
    {
        array_shift($rows);
        foreach ($rows as $row) {
            $user = User::where('employee_id', intval($row[0]))->first();
            if(!$user) {
                $user = User::create([
                    'employee_id' => intval($row[0]),
                    'name' => $row[1],
                    'role' => 'user',
                ]);
            } else if ($user->name != $row[1]) {
                $user->update([
                    'name' => $row[1],
                ]);
            }
        }
    }
}
