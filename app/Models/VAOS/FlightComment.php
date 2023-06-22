<?php

namespace App\Models\VAOS;

use Illuminate\Database\Eloquent\Model;

class FlightComment extends Model
{
    protected $connection = "vaos";
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function flight()
    {
        return $this->belongsTo('App\Models\Flight');
    }
}
