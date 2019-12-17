<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
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
        'active'
    ];

    protected $hidden = [
        'password'
    ];

    public function findForPassport($identifier) {
        return $this->orWhere('email', $identifier)
            ->orWhere('username', $identifier)
            ->first();
    }

    public function getDateFormat()
    {
        return 'Y-m-d H:i:s.u';
    }
}
