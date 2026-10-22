<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_number',
        'sale_date',
        'customer_name',
        'total_amount',
        'discount',
        'payment_amount',
        'payment_method',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'sale_date' => 'date',
            'total_amount' => 'decimal:2',
            'discount' => 'decimal:2',
            'payment_amount' => 'decimal:2',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }
}
