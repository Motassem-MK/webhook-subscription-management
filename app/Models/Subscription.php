<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'service',
        'status',
        'started_at',
        'expires_at',
        'user_id',
        'original_transaction_id',
    ];

    const PAYMENT_SERVICE_APPSTORE = 'appstore_server_notification';

    const ALLOWED_PAYMENT_SERVICES = [
        self::PAYMENT_SERVICE_APPSTORE,
    ];

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    const ALLOWED_STATUSES = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE,
    ];
}
