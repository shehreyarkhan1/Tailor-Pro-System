<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Measurement;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Customer extends Model
{
    protected $fillable =[
        'customer_code',
        'name',
        'phone',
        'whatsapp',
        'address',
        'gender',
        'city',
        'notes',
        'is_vip',
    ];
    protected function casts(): array
    {
        return[
            'is_vip'=>'boolean',
        ];
    }
    public function measurements(): HasMany
    {
        return $this->hasMany(Measurement::class);
    }
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
    public function latestMeasurement()
    {
        return $this->hasOne(Measurement::class)->latestOfMany();
    }
    public static function generateCode(): string
    {
     $last=static::max('id') ?? 0;
     return 'CUST-' . str_pad($last + 1, 4, '0', STR_PAD_LEFT);
    }
}
