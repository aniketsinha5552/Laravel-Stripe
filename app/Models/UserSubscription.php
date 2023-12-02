<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;
    protected $table = 'user_subscriptions';

    protected $fillable = [
        'user_id',
        'plan',
        'stripe_customer',
        'stripe_subscription',
        'stripe_price',
        'current_period_end',
    ];
}
