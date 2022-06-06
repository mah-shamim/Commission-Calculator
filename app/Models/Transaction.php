<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Transaction extends Authenticatable
{
    protected $primaryKey = 'transaction_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transaction_id',
        'operation_date',
        'user_identification',
        'user_type',
        'operation_type',
        'operation_amount',
        'operation_currency',
        'commission_amount',
        'deposit_charge',
        'withdraw_charge',
        'week_number_year',
        'transaction_frequency',
        'converted_operation_amount',
        'converted_operation_currency',
        'converted_chargeable_amount',
        'converted_chargeable_amount_currency',
        'target_charge'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'operation_date' => 'date'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'commission_amount' => 0,
        'deposit_charge' => 0,
        'withdraw_charge' => 0,
        'week_number_year' => 0,
        'transaction_frequency' => 0,
        'target_charge' => 0
    ];
}
