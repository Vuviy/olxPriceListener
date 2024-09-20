<?php

namespace App\Models;

use App\Contracts\IFilter;
use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'age',
        'last_activity',
    ];

    public function interests():BelongsToMany
    {
        return $this->belongsToMany(Interest::class);
    }

    public function scopeFilter(Builder $builder, IFilter $filter)
    {

        return $filter->apply($builder);
    }


    public function chats()
    {

        $chats1 = $this->hasMany(Chat::class, 'sender_id')->get();
        $chats2 = $this->hasMany(Chat::class, 'recipient_id')->get();

        $marged = $chats1->merge($chats2);

        return $marged->sortByDesc('updated_at');
    }

    public function offers():HasMany
    {
        return $this->hasMany(Offer::class);
    }

    public function payedContents()
//    public function payedContents():HasMany
    {
         return $this->hasMany(PayedContent::class, 'user_id')->pluck('feed_id')->unique()->toArray();
    }

    public function feeds():HasMany
    {
        return $this->hasMany(Feed::class)->orderByDesc('created_at');
    }

    public function responds():HasMany
    {
        return $this->hasMany(OfferRespond::class)->orderByDesc('created_at');
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function billing(): HasOne
    {
        return $this->hasOne(Billing::class);
    }

    public function info(): HasOne
    {
        return $this->hasOne(UserInfo::class);
    }

    public function fastDateInfo(): HasOne
    {
        return $this->hasOne(FastDateInfo::class);
    }
}
