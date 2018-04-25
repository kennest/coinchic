<?php
/**
 * Created by PhpStorm.
 * Users: kenny
 * Date: 06/11/17
 * Time: 15:57
 */

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title', 'picture', 'start', 'end'];


    public function type(){
        return $this->belongsTo(Type::class,'type_id');
    }

    public function place(){
        return $this->belongsToMany(Place::class, 'place_id');
    }

    public function scopeActive($query)
    {
        return $query->where('end', '>=', Carbon::now()->toDateString());
    }

    public function scopeInactive($query){
        return $query->where('end', '<', Carbon::now()->toDateString());
    }

    public function getBeginAttribute($value){
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function getEndAttribute($value){
        return Carbon::parse($value)->format('Y-m-d');
    }

}