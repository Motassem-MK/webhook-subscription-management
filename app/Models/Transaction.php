<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    const TYPE_FIRST_PURCHASE = 'first_purchase';
    const TYPE_RENEWAL_SUCCESS = 'successful_renewal';
    const TYPE_RENEWAL_FAIL = 'failed_renewal';
    const TYPE_CANCELLATION = 'cancellation';

    const ALLOWED_TYPES = [
        self::TYPE_FIRST_PURCHASE,
        self::TYPE_RENEWAL_SUCCESS,
        self::TYPE_RENEWAL_FAIL,
        self::TYPE_CANCELLATION,
    ];
}
