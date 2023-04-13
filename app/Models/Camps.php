<?php

namespace App\Models;

use App\Models\Checkout;
use App\Models\CampBenefit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Camps extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'price',
    ];

    // mengecek jika ada yang beli kelas sama dengan akun yang sama
    public function getIsRegisteredAttribute()
    {
        if (!Auth::check()) {
            return false;
        }

        return Checkout::whereCampId($this->id)->whereUserId(Auth::id())->exists();
    }

}
