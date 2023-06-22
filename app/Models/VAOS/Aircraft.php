<?php

namespace App\Models\VAOS;

use Illuminate\Database\Eloquent\Model;

class Aircraft extends Model
{
    protected $table = 'aircraft';
    protected $connection = "vaos";
    public function hub()
    {
        return $this->belongsTo('App\Models\Hub');
    }

    public function location()
    {
        return $this->belongsTo('App\Models\Airport');
    }

    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function aircraft_group()
    {
        return $this->belongsToMany(AircraftGroup::class, 'aircraft_group_pivot');
    }

    public function type_rating()
    {
        return $this->belongsTo('App\Models\TypeRating');
    }

    public function flights()
    {
        return $this->hasMany(Flight::class);
    }

    public function isAvailable()
    {
        $active = $this->flights()->filed()->active()->get();
        if ($active->isEmpty()) {
            return true;
        }
        return false;
    }
}
