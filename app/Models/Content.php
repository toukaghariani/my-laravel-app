<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Genre;
use App\Models\WatchHistory;
use App\Models\User;

class Content extends Model
{
    use HasFactory;

    // Fillable: columns safe for mass assignment(manually filled by user,Laravel defaults are excluded)
    protected $fillable = [
        'title',
        'description',
        'language',
        'type',
        'release_year',
        'thumbnail_url',
        'streaming_url',
        'is_premium',
    ];

    // Casts: how Laravel treats certain column types
    protected $casts = [
        'is_premium'   => 'boolean',
        'release_year' => 'integer',
    ];

    //Database Relationships(defined inside UML class diagram)

    // A content belongs to many genres through contentgenres pivot
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'contentgenres');
    }

    // A content has many watch history entries
    public function watchHistory()
    {
        return $this->hasMany(WatchHistory::class, 'content_id');
    }

    // A content can be in many users watchlists through watchlists pivot
    public function watchlistUsers()
    {
        return $this->belongsToMany(User::class, 'watchlists');
    }

    //helpers
    public function isPremium(): bool
    {
        return $this->is_premium === true;
    }
}
