<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    const UPDATED_AT = 'last_update';
    const CREATED_AT = null;

    protected $table = 'address';
    protected $primaryKey = 'address_id';

    protected $fillable = [
        'address_id',
        'address',
        'district',
        'city_id',
        'postal_code',
        'phone',
        'last_update'
    ];
}
