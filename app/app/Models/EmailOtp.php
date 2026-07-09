<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailOtp extends Model
{
    protected $fillable = [
        'email',
        'otp',
        'expires_at',
        'used'
    ];

    protected $casts = [
        'expires_at' => 'datetime'
    ];
}
