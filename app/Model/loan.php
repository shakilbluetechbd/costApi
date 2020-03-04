<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class loan extends Model
{
    protected $guarded = [];
    //
    public function user()
    {
        return $this->belongsTo('App\User', 'foreign_key', 'other_key');
    }
}
