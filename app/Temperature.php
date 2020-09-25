<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Temperature extends Model
{
    protected $guarded = [];
    
    public function employee() {
        return $this->belongsTo(Employee::class);
    }
}
