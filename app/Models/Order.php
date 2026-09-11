<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [

        'order_number',
        'customer_id',
        'measurement_id',
        'assigned_staff_id',
        'order_date',
        'delivery_date',
        'status',
        'priority',
        'total_amount',
        'advance_paid',
        'notes',
    ];

    protected $casts = [
        'order_date' => 'date',
        'delivery_date' => 'date',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function measurement(): BelongsTo
    {
        return $this->belongsTo(Measurement::class);
    }

    public function assignedStaff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'assigned_staff_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public function selectedOption(string $categoryCode): ?StyleOption
    {
        return $this->styleSelections
            ->first(fn ($sel) => $sel->category->code === $categoryCode)
            ?->option;
    }

    public function styleSelections(): HasMany
    {
        return $this->hasMany(OrderStyleSelection::class);
    }

    public function remainingAmount(): float
    {
        return (float) $this->total_amount - (float) $this->advance_paid;
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'pending' => 'bg-slate-100 text-slate-700 ring-slate-600/20',
            'cutting' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
            'stitching' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
            'finishing' => 'bg-indigo-50 text-indigo-700 ring-indigo-600/20',
            'ready' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
            'delivered' => 'bg-teal-50 text-teal-700 ring-teal-600/30',
            'cancelled' => 'bg-red-50 text-red-700 ring-red-600/20',
            default => 'bg-slate-100 text-slate-700 ring-slate-600/20',
        };
    }

    public static function generateOrderNumber(): string
    {
        $year = now()->format('Y');

        $lastOrderNumber = static::where('order_number', 'like', "ORD-{$year}-%")
            ->orderByDesc('id')
            ->value('order_number');

        if ($lastOrderNumber) {
            $lastNumber = (int) substr($lastOrderNumber, -4);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return "ORD-{$year}-".str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
