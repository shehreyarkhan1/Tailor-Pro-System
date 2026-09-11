<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'item_name',
        'fabric_style',
        'quantity',
        'unit_price',
    ];
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
    public function lineTotal(): float
    {
        return (float) $this->quantity * (float) $this->unit_price;
    }

}
