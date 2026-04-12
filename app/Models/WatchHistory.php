<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Content;

class WatchHistory extends Model
{
    use HasFactory;

    protected $table = 'watchhistories';

    protected $fillable = [
        'user_id',
        'content_id',
        'watched_seconds',
        'watched_at',
    ];

    protected $casts = [
        'watched_at'     => 'datetime',
        'watched_seconds' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function content()
    {
        return $this->belongsTo(Content::class);
    }
}
