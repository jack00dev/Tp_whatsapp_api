<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'user_id',
        'owner_id',
        'last_name',
        'first_name',
        'email',
        'phone_number',
    ];
}
