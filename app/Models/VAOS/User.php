<?php

namespace App\Models\VAOS;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = "vaos";
    protected $fillable = [
        'first_name', 'last_name', 'username', 'email', 'password', 'vatsim', 'ivao', 'status', 'admin', 'name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function flights()
    {
        return $this->hasMany('App\Models\Flight');
    }

    public function group()
    {
        return $this->belongsToMany('App\Models\Group');
    }

    public function aircraft()
    {
        return $this->hasMany('App\Models\Aircraft');
    }

    /*
     * COMPUTED PROPERTIES
     */

    public function avgLandingRate()
    {
        return $this->flights()
            ->selectRaw('avg(landingrate) as aggregate, user_id')
            ->groupBy('user_id');
    }

    public function getAvgLandingRateAttribute()
    {
        if ( ! array_key_exists('avgLandingRate', $this->relations)) {
            $this->load('avgLandingRate');
        }

        $relation = $this->getRelation('avgLandingRate')->first();

        return ($relation) ? $relation->aggregate : null;
    }

    public function totalFlightTime()
    {
        return $this->flights()
            ->selectRaw('sum(flighttime) as aggregate, user_id')
            ->groupBy('user_id');
    }

    public function getTotalFlightTimeAttribute()
    {
        if ( ! array_key_exists('totalFlightTime', $this->relations)) {
            $this->load('totalFlightTime');
        }

        $relation = $this->getRelation('totalFlightTime')->first();

        return ($relation) ? $relation->aggregate : null;
    }

    public function totalFlights()
    {
        return $this->flights()
            ->selectRaw('count(*) as aggregate, user_id')
            ->groupBy('user_id');
    }

    public function getTotalFlightsAttribute()
    {
        if ( ! array_key_exists('totalFlights', $this->relations)) {
            $this->load('totalFlights');
        }

        $relation = $this->getRelation('totalFlights')->first();

        return ($relation) ? $relation->aggregate : null;
    }

    public function airlines()
    {
        return $this->belongsToMany('App\Models\Airline')->withPivot('pilot_id', 'status', 'primary', 'admin');
    }

    public function hasAirline($airline)
    {
        return $this->airlines->contains($airline);
    }

    public function full_name() {
        return $this->first_name." ".$this->last_name;
    }
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
