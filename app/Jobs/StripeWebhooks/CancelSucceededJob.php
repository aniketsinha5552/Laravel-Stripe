<?php

namespace App\Jobs\StripeWebhooks;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\WebhookClient\Models\WebhookCall;
use App\Models\User;
use App\Models\UserSubscription;


class CancelSucceededJob implements ShouldQueue
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
            $sub= UserSubscription::where('stripe_subscription',$charge['id'])->first();
            $sub->status = '0';
            $sub->save();
            return $sub;
           
        }catch(Exception $e){
            return $e;
        }
    }
}

