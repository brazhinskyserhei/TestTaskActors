<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Staff extends Authenticatable
{
    use HasApiTokens, Notifiable;

    const UPDATED_AT = 'last_update';
    const CREATED_AT = null;

    protected $table = 'staff';
    protected $primaryKey = 'staff_id';


    protected $fillable = [
        'staff_id',
        'first_name',
        'last_name',
        'address_id',
        'store_id',
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password'
    ];


}
