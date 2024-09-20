<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FastDateInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'age',
        'gender',
        'height',
        'weight',
        'hair_color',
        'boobs_size',
        'ass_girth',
        'waistline',
        'dick_length',
        'goal_here',
    ];



    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
