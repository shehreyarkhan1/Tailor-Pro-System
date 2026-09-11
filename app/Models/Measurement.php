<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Measurement extends Model
{
    protected $fillable =[
        'customer_id',
        'garment_type',
        "length",
        'chest',
        'waist',
        'hips',
        'shoulder',
        'sleeve_length',
        'collar',
        'armhole',
        'bicep',
        'shalwar_length',
        'paincha',
        'style_notes',
    ];
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
