<?php

namespace App\Models\VAOS;

use Illuminate\Database\Eloquent\Model;

class AirlineEvent extends Model
{
    public $timestamps = false;
    protected $connection = "vaos";
    public function users()
    {
        return $this->belongsToMany('App\Models\User')->withPivot(['status', 'role']);
    }

    public function airline()
    {
        return $this->belongsTo('App\Models\Airline');
    }

    public function flights()
    {
        return $this->hasMany('App\Models\AirlineEventFlight');
    }
}
