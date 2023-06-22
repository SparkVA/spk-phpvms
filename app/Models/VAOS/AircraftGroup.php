<?php

namespace App\Models\VAOS;

use Illuminate\Database\Eloquent\Model;

class AircraftGroup extends Model
{
    //
    public $table = 'aircraft_groups';
    protected $connection = "vaos";
    protected $fillable = ['name', 'icao', 'userdefined'];

    public function aircraft()
    {
        return $this->belongsToMany(Aircraft::class, 'aircraft_group_pivot');
    }

    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }

    public function schedule()
    {
        return $this->belongsToMany(Schedule::class);
    }

    public function isAvailable($aircraft_id)
    {
    }
}
