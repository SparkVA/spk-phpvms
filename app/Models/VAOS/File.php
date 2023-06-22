<?php

namespace App\Models\VAOS;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public function category() {
        return $this->belongsTo('App\Models\FileCategory');
    }
}
