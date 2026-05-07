<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'order_number',
    'recipient_name',
    'phone',
    'shipping_address',
    'city',
    'postal_code',
    'cart_snapshot',
    'subtotal',
    'shipping_cost',
    'total_price',
    'status',
])]
class CheckoutSession extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'cart_snapshot' => 'array',
            'subtotal' => 'decimal:2',
            'shipping_cost' => 'decimal:2',
            'total_price' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
