<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Order;
use App\Models\StyleCategory;

class OrderStyleSelection extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'style_category_id', 'style_option_id', 'notes',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(StyleCategory::class, 'style_category_id');
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(StyleOption::class, 'style_option_id');
    }
}
