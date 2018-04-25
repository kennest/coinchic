<?php
/**
 * Created by PhpStorm.
 * Users: kenny
 * Date: 06/11/17
 * Time: 15:57
 */

namespace App\Models;


use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Owner extends Authenticatable
{
    use Notifiable;
    protected $fillable = ['name', 'number', 'email', 'password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function places(){
        return $this->hasMany(Place::class, 'place_id');
    }

}