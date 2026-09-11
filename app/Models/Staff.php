<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Order;

class Staff extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'phone',
        'role',
        'monthly_salary',
        'is_active',
    ];
    public function casts(): array
    {
        return
        [
            'is_active'=>'boolean',
        ];

    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class,'assigned_staff_id');
    }

    public function roleLabel(): string
    {
        return match($this->role)
        {
            'master_tailor'=> 'Master Tailor (Ustad)',
            'cutter'=>'Cutter',
            'sticher'=>'Sticher',
            'finisher'=>'Finisher',
            'manager'=>'Manager',
            default=>ucfirst($this->role),
        };
    }
}
