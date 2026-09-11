<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\StyleOption;

class StyleCategory extends Model
{
     use HasFactory;

    protected $fillable = [
        'name', 'code', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function options(): HasMany
    {
        return $this->hasMany(StyleOption::class);
    }

    public function activeOptions(): HasMany
    {
        return $this->hasMany(StyleOption::class)->where('is_active', true)->orderBy('sort_order');
    }
}
