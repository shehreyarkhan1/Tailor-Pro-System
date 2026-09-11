<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\StyleCategory;

class StyleOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'style_category_id', 'name', 'code', 'icon_path', 'swatch_color',
        'description', 'extra_price', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'extra_price' => 'decimal:2',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(StyleCategory::class, 'style_category_id');
    }

    public function selections(): HasMany
    {
        return $this->hasMany(OrderStyleSelection::class);
    }

    // Frontend ke liye ready-to-use icon URL, agar icon_path set hai
    public function iconUrl(): ?string
    {
        return $this->icon_path ? asset('storage/'.$this->icon_path) : null;
    }
}
