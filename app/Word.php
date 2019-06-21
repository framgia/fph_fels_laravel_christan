<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function choices()
    {
        return $this->hasMany(Choice::class);
    }
}