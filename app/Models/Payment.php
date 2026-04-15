<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\SubscriptionPlan;
use App\Models\Subscription;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'amount',
        'gateway',
        'status',
        'transaction_id',
        'metadata',
    ];

    protected $casts = [
        'amount' => 'float',
        'metadata' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id');
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class, 'payment_id');
    }
}
