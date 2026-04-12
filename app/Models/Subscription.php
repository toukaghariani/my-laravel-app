<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Carbon;

class Subscription extends Model
{
    //use Carbon\Carbon;
    use HasFactory;
    protected $fillable = [
        'user_id',
        'plan_id',
        'payment_id',
        'status',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'starts_at'   => 'datetime',
        'ends_at' => 'datetime',
    ];

    //Database Relationships(defined inside UML class diagram)

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    //a subscription belongs to a subscription plan
    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    //helpers
    public function isActive(): bool
    {
        return $this->status === 'active' && $this->ends_at->isFuture();
    }
}
