<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'sku',
        'category',
        'stock_quantity',
        'image_url',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'status' => 'boolean',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function getFormattedPriceAttribute()
    {
        return '¥' . number_format($this->price);
    }

    public function getStockStatusAttribute()
    {
        if ($this->stock_quantity <= 0) {
            return '在庫切れ';
        } elseif ($this->stock_quantity <= 10) {
            return '在庫僅少';
        } else {
            return '在庫あり';
        }
    }

    public function getStatusDisplayAttribute()
    {
        return $this->status ? '有効' : '無効';
    }
}
