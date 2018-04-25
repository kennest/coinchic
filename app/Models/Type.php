<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table='types';
    protected $fillable=['type'];

    public function Events(){
        return $this->hasMany(Event::class);
    }
}
