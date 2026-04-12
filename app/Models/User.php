<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Columns that can be mass-assigned
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    // Columns never exposed in JSON responses
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // How Laravel treats certain columns
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    //RELATIONSHIPS

    // A user has many subscriptions
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    // A user's current active subscription (only one)
    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)
                    ->where('status', 'active')
                    ->latest();
    }

    // A user has many watch history entries
    public function watchHistory()
    {
        return $this->hasMany(WatchHistory::class);
    }

    // A user has many payments
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function watchlist()
    {
        return $this->belongsToMany(Content::class, 'watchlists');
    }

    // Returns true if user has an active non-expired subscription
    public function hasActiveSub(): bool
    {
        return $this->subscriptions()
                    ->where('status', 'active')
                    ->where('ends_at', '>', now())
                    ->exists();
    }

    // Returns true if user is an administrator
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
