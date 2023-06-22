<?php

namespace App\Models\VAOS;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    protected $fillable = ['id', 'name', 'city', 'country', 'iata', 'icao', 'lat', 'lon', 'data'];
    protected $connection = "vaos";
    public $timestamps = false;

    public function scheduled_dep()
    {
        return $this->hasMany('App\Models\Schedule', 'depapt_id');
    }

    public function users()
    {
        return $this->hasMany('App\Models\User');
    }
}
