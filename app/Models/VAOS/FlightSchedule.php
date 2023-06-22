<?php

namespace App\Models\VAOS;

use Illuminate\Database\Eloquent\Model;

class FlightSchedule extends Model
{
    protected $connection = "vaos";
    protected $table = 'schedules';
}
