<?php

namespace App\Models\VAOS;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public $table = 'schedules';
    protected $connection = "vaos";
    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }

    public function depapt()
    {
        return $this->belongsTo(Airport::class);
    }

    public function arrapt()
    {
        return $this->belongsTo(Airport::class);
    }

    public function aircraft_group()
    {
        return $this->belongsToMany(AircraftGroup::class)->withPivot('primary');
    }

    public function aircraft()
    {
        return $this->belongsToMany(Aircraft::class);
    }

    // Eloquent Eger Loading Helper
    public static function allFK()
    {
        return with('depicao')->with('arricao')->with('airline')->with('aircraft_group')->get();
    }
    public function getCallsign()
    {
        if (is_null($this->airline_id) && is_null($this->callsign)) {
            return $this->flightnum;
        }
        if (is_null($this->callsign)) {
            return $this->airline->icao.$this->flightnum;
        }
        if (is_null($this->callsign) && is_null($this->flightnum)) {
            return 'N/A';
        } else {
            return $this->callsign;
        }
    }
}
