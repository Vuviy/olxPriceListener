<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable= ['url', 'ad_id', 'price'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function verifiedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->whereNotNull('email_verified_at');
    }
}
