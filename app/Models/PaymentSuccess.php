<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSuccess extends Model
{
    use HasFactory;
    protected $table = "payment_success";
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'stripe_charge_id',
        'amount',
        'currency',
        'payment_status',
        'stripe_response',
        'status',
    ];
}
