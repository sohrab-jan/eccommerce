<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    public function statusColor(): string
    {
        $color = match ($this->status) {
            'new' => 'blue',
            'processing' => 'yellow',
            'shipped' => 'green',
            'delivered' => 'pink',
            'canceled' => 'red',
            default => 'gray',
        };

        return $color;
    }

    public function paymentStatusColor(): string
    {
        $color = match ($this->payment_status) {
            'pending' => 'blue',
            'failed' => 'red',
            'paid' => 'green',
            default => 'yellow',
        };

        return $color;
    }
}
