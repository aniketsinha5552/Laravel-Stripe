<?php

namespace App\Http\Controllers;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserSubscription;

class PlanController extends Controller
{
    public function getPlans(Request $request){
        $plans = Plan::all();
        return $plans;
    }

    public function getUserPlan(Request $request){
        $sub = UserSubscription::where('user_id',$request->user_id)->where('status','1')->first();

        if(!$sub){
            return ['id'=>0];
        }
        $plan= Plan::where('id',$sub['plan'])->first();

        return $plan;
    }

    public function subscribe(Request $request){
        $plan = Plan::find($request->plan);
        $user = User::find($request->user_id);

        $base_url = env('HOST_URL');
        
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET',""));
        $session = $stripe->checkout->sessions->create([
            'success_url' => $base_url.'/dashboard',
            'cancel_url'=>  $base_url.'/dashboard',
            'payment_method_types'=> ["card"],
            'mode'=> "subscription",
            'billing_address_collection'=> "auto",
            'customer_email'=> $user['email'],
            'line_items'=> [
                [
                'price_data'=> [
                    'currency'=> "INR",
                    'product_data'=> [
                    'name'=> $plan->name,
                    'description'=> $plan->desc,
                    ],
                    'unit_amount'=> $plan->price,
                    'recurring'=> [
                    'interval'=> "month"
                ]
                ],
                'quantity'=> 1,
            ],
            ],
            'metadata'=> [
                "user"=>$user->id,
                "plan"=>$plan->id
            ]
            ]);
        return $session;
        
    }

    public function unsubscribe(Request $request){
        $base_url = env('HOST_URL');
        $plan = Plan::find($request->plan);
        $user = User::find($request->user_id);
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET',""));

        $sub= UserSubscription::where('user_id',$request->user_id)
        ->where('plan',$request->plan)
        ->where('status','1')->first();
       

        $session = $stripe->billingPortal->sessions->create([
            'customer'=> $sub['stripe_customer'],
            'return_url'=>  $base_url.'/dashboard'
        ]);
        return $session;

    }
}
