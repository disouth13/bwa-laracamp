<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Checkout extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'users_id',
        'camps_id',
        'card_number',
        'expired',
        'cvc',
        'status_paid',
    ];

    // setting date expired
    public function setExpiredAttribute($value)
    {
        $this->attributes['expired'] = date('Y-m-t', strtotime($value));
    }

}
