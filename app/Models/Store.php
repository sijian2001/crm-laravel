<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'opening_hours',
        'closed_days',
        'status',
        'manager_name',
        'opening_date',
        'description',
    ];

    protected $casts = [
        'opening_date' => 'date',
        'status' => 'string',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('manager_name', 'like', "%{$search}%");
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function getStatusDisplayAttribute()
    {
        $statuses = [
            'open' => '営業中',
            'closed' => '休業中',
            'preparing' => '準備中',
        ];

        return $statuses[$this->status] ?? '不明';
    }

    public function getStatusBadgeClassAttribute()
    {
        $classes = [
            'open' => 'bg-success',
            'closed' => 'bg-danger',
            'preparing' => 'bg-warning',
        ];

        return $classes[$this->status] ?? 'bg-secondary';
    }

    public function getFormattedOpeningDateAttribute()
    {
        return $this->opening_date ? $this->opening_date->format('Y年m月d日') : '';
    }

    public function getIsOpenAttribute()
    {
        return $this->status === 'open';
    }
}
