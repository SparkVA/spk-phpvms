<?php

namespace App\Models\VAOS;

use Illuminate\Database\Eloquent\Model;

class FlightData extends Model
{
    protected $table   = 'flight_data';
    protected $guarded = [];
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
