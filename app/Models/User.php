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

class User extends Model
{
    protected $fillable = ['username', 'picture', 'birthday', 'sex'];

    public function artists()
    {
        return $this->belongsToMany(Artist::class)->withPivot('artist_id');
    }

    public function type(){
        return $this->belongsTo(Type::class,'type_id');
    }
}