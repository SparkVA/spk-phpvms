<?php

namespace App\Models\VAOS;

use Illuminate\Database\Eloquent\Model;

class FileCategory extends Model
{
    //
    protected $table = "file_categories";
    public function files() {
        return $this->hasMany('App\Models\File', 'category_id');
    }
    public function parent_category() {
        return $this->belongsTo('App\Models\FileCategory');
    }
}
