<?php

namespace App\Models\VAOS;

use Illuminate\Database\Eloquent\Model;

class Hub extends Model
{
    protected $connection = "vaos";
    public function airport()
    {
        return $this->belongsTo('App\Models\Airport');
    }

    public function airline()
    {
        return $this->belongsTo('App\Models\Airline');
    }

    public function user()
    {
        return $this->hasMany('App\Models\User');
    }
}
