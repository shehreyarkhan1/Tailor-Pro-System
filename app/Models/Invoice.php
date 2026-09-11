<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\DB;


class Invoice extends Model
{
    protected $fillable = [
        'invoice_number',
        'order_id',
        'amount',
        'paid_amount',
        'status',
        'issue_date',
    ];

    public function casts(): array
    {
        return ['issue_date' => 'date'];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function balanceDue(): float
    {
        return (float) $this->amount - (float) $this->paid_amount;
    }

    public static function generateInvoiceNumber(): string
    {
        $year = now()->format('Y');
        $count = static::whereYear('created_at', now()->year)->count() + 1;

        return "INV-{$year}-".str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
