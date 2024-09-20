<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'description'];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function responds(): HasMany
    {
        return $this->hasMany(OfferRespond::class);
    }
}
