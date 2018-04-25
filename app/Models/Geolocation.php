<?php
/**
 * Created by PhpStorm.
 * User: kenny
 * Date: 09/11/17
 * Time: 10:04
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Geolocation extends Model
{
    protected $fillable = ['lat', 'long','place_id'];

    public function place()
    {
        return $this->belongsTo(Place::class,'place_id');
    }

}