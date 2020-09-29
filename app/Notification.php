<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $guarded = [];

    protected $with = ['user', 'temperature'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function temperature() {
        return $this->belongsTo(Temperature::class);
    }
}
