<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    const UPDATED_AT = 'last_update';
    const CREATED_AT = null;

    protected $table = 'store';
    protected $primaryKey = 'store_id';

    protected $fillable = [
        'store_id',
        'manager_staff_id',
        'address_id',
        'last_update',
    ];
}
