<?php

namespace App\Models;

use App\Models\Camps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Checkout extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'camp_id',
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

    // relasi camp
    public function Camp(): BelongsTo
    {
        return $this->belongsTo(Camps::class);
    }

    // relasi user
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
