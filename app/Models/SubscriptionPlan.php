<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Subscription;

class SubscriptionPlan extends Model
{
    use HasFactory;
    protected $table='subscriptionplans';

    protected $fillable=[
        'name',
        'price',
        'duration_days',
        'features',
    ];
    protected $casts=[
        'price'=> 'float',
        'duration_days'=>'integer',
    ];
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'plan_id');
    }
}
