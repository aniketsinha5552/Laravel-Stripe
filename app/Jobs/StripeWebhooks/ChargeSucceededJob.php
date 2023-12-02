<?php

namespace App\Jobs\StripeWebhooks;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\WebhookClient\Models\WebhookCall;
use App\Models\User;
use App\Models\UserSubscription;


class ChargeSucceededJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /** @var \Spatie\WebhookClient\Models\WebhookCall */
    public $webhookCall;

    public function __construct(WebhookCall $webhookCall)
    {
        $this->webhookCall = $webhookCall;
    }

    public function handle()
    {
        try{
            $charge = $this->webhookCall->payload['data']['object'];
            $user= User::where('id',$charge['metadata']['user'])->first();
    
            if($user){
                $sub= UserSubscription::create([
                    'user_id'=> $user->id,
                    'plan'=>$charge['metadata']['plan'],
                    'stripe_price'=>$charge['id'],
                    'stripe_customer'=>$charge['customer'],
                    'stripe_subscription'=>$charge['subscription'],
                    'current_period_end'=> $charge['expires_at']
                ]);
                
                return $sub;
            }
           
        }catch(Exception $e){
            return $e;
        }
    }
}

