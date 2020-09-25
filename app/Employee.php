<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = [];

    public function temperatures() {
        return $this->hasMany(Temperature::class);
    }
    
}
