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

class Advise extends Model
{
    protected $fillable = ['like', 'dislike'];

    public function user()
    {
        return $this->belongsTo(User::class)->withPivot('user_id');
    }

    public function place(){
        return $this->belongsTo(Place::class, 'place_id');
    }

}