<?php

namespace App\Models\VAOS;

use Illuminate\Database\Eloquent\Model;

class ExtHour extends Model
{
    protected $connection = "vaos";
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
