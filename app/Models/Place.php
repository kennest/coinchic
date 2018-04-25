<?php
/**
 * Created by PhpStorm.
 * Users: kenny
 * Date: 06/11/17
 * Time: 15:55
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = ['title','picture'];
    
    protected $table='places';

    public function owner(){
        return $this->belongsTo(Owner::class);
    }
    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    public function geolocation(){
        return $this->hasOne(Geolocation::class);
    }

    public function getPictureAttribute($value){
        return $value;
    }

    public function activeEvents(){
        return $this->events()->active();
    }
}