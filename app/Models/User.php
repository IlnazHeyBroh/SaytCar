<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Bb;
use App\Models\Category;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    public function bbs() {
        return $this->hasMany(Bb::class);
    }

    public function favoriteBbs()
    {
        return $this->belongsToMany(Bb::class, 'favorites')->withTimestamps();
    }

    public function buyerConversations()
    {
        return $this->hasMany(Conversation::class, 'buyer_id');
    }

    public function sellerConversations()
    {
        return $this->hasMany(Conversation::class, 'seller_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function hasFavorited(Bb $bb): bool
    {
        return $this->favoriteBbs()->where('bb_id', $bb->id)->exists();
    }

    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
    }
}
