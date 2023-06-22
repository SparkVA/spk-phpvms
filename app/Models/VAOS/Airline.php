<?php

namespace App\Models\VAOS;

use Illuminate\Database\Eloquent\Model;

class Airline extends Model
{
    protected $fillable = [
        'name',
        'iata',
        'icao',
        'callsign',
        'hub_id',
        'color_primary',
        'color_secondary',
        'color_highlight',
        'autoAccept',
        'isAccepting',
        'autoAdd',
        'aaEnabled',
        'aaLandingRate',
    ];
    protected $connection = "vaos";
    public $timestamps = false;

    public function hubs()
    {
        return $this->belongsToMany(Airport::class, 'hubs')->withPivot('id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('pilot_id', 'status', 'primary', 'admin');
    }
    public function aircraft_groups()
    {
        return $this->hasMany(AircraftGroup::class);
    }
}
