<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = ['label', 'lat', 'long'];
    protected $table = 'districts';

    public function places()
    {
        return $this->hasMany(Place::class);
    }
}
