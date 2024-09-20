<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfferRespond extends Model
{

    protected $fillable = ['user_id', 'offer_id', 'comment', 'status'];

    use HasFactory;

    public function offer():BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
