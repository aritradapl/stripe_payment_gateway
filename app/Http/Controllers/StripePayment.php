<?php

namespace App\Http\Controllers;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\PaymentSuccess;
use Illuminate\Support\Facades\Hash;

class StripePayment extends Controller
{
    protected $stripe;
    protected $currency;
    protected $secretkey;
    public function __construct()
    {
        $secret_key = \Config::get('services.stripe.secret');
        $this->currency = \Config::get('services.stripe.currency');
        $this->stripe = new \Stripe\StripeClient($secret_key);
        $this->secretkey = $secret_key;
    }
    public function userData(Request $request)
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password,
        ]);
        $stripeCustomer=$user->createOrGetStripeCustomer(); // create stripe_id for instructor
        $stripeId=$user->stripe_id; // Retrive stripe_id 
        $amount = 100.00;
        $currency=$this->currency;
        $checkout_session = $this->stripe->checkout->sessions->create([
            'line_items' => [[
            'price_data' => [
            'currency' => $currency,
            'product_data' => [
                  'name' => 'Test Payment',
            ],
            'unit_amount' => $amount *100 ,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
                'success_url' => route('checkout-success').'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout-cancel'),
                'customer' => $stripeId,
                'metadata' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ]
                ]);
                return redirect()->away($checkout_session->url);
      
    }
    public function paymentSuccess(Request $request)
    {
       // Get the session ID from the query parameters
        $session_id = $request->input('session_id');
        // Set Stripe secret key
        $stripe = Stripe::setApiKey($this->secretkey);
        // Retrieve the session data from Stripe
        $session = Session::retrieve($session_id);
       
        $paymentIntentId=$session->payment_intent;
       
        // Retrieve the payment intent using its ID
        $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
        $user_id=$session->metadata->id;
      
        $name=$session->metadata->name;
        $email=$session->metadata->email; 
        $stripe_charge_id=$session->payment_intent;
        $amount=$session->amount_total/100; 
        $currency=$session->currency; 
        $stripe_response=json_encode($session); 
      
        $payment_method_type = $session->payment_method_types; 
        $payment_method = $payment_method_type[0]; 
        PaymentSuccess::create([
            'user_id' => $user_id,
            'name' => $name ,
            'email' => $email,
            'stripe_charge_id' => $stripe_charge_id,
            'amount' =>  $amount,
            'currency' => $currency,
            'payment_status' => 1,
            'stripe_response' => $stripe_response,
            'status' => 1,
         ]);
       dd('success');
    }
    public function paymentCancel()
    {
        dd('failure');
    }
}
