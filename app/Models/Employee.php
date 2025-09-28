<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'first_name_kana',
        'last_name_kana',
        'email',
        'phone',
        'address',
        'birth_date',
        'hire_date',
        'termination_date',
        'employment_type',
        'position',
        'salary',
        'hourly_wage',
        'department',
        'status',
        'store_id',
        'notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'hire_date' => 'date',
        'termination_date' => 'date',
        'salary' => 'decimal:0',
        'hourly_wage' => 'decimal:0',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%")
              ->orWhere('first_name_kana', 'like', "%{$search}%")
              ->orWhere('last_name_kana', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('department', 'like', "%{$search}%");
        });
    }

    public function scopeByStore($query, $storeId)
    {
        return $query->where('store_id', $storeId);
    }

    public function scopeByPosition($query, $position)
    {
        return $query->where('position', $position);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function getFullNameAttribute()
    {
        return $this->last_name . ' ' . $this->first_name;
    }

    public function getFullNameKanaAttribute()
    {
        return $this->last_name_kana . ' ' . $this->first_name_kana;
    }

    public function getPositionDisplayAttribute()
    {
        $positions = [
            'manager' => '店長',
            'assistant_manager' => '副店長',
            'supervisor' => '主任',
            'senior_staff' => '主任スタッフ',
            'staff' => 'スタッフ',
            'trainee' => '研修生',
        ];

        return $positions[$this->position] ?? '不明';
    }

    public function getEmploymentTypeDisplayAttribute()
    {
        $types = [
            'full_time' => '正社員',
            'part_time' => 'パートタイム',
            'contract' => '契約社員',
            'temporary' => '臨時雇用',
        ];

        return $types[$this->employment_type] ?? '不明';
    }

    public function getStatusDisplayAttribute()
    {
        $statuses = [
            'active' => '在職中',
            'inactive' => '休職中',
            'on_leave' => '休暇中',
            'terminated' => '退職済み',
        ];

        return $statuses[$this->status] ?? '不明';
    }

    public function getStatusBadgeClassAttribute()
    {
        $classes = [
            'active' => 'bg-success',
            'inactive' => 'bg-warning',
            'on_leave' => 'bg-info',
            'terminated' => 'bg-danger',
        ];

        return $classes[$this->status] ?? 'bg-secondary';
    }

    public function getFormattedSalaryAttribute()
    {
        return $this->salary ? '¥' . number_format($this->salary) : null;
    }

    public function getFormattedHourlyWageAttribute()
    {
        return $this->hourly_wage ? '¥' . number_format($this->hourly_wage) : null;
    }

    public function getFormattedHireDateAttribute()
    {
        return $this->hire_date ? $this->hire_date->format('Y年m月d日') : '';
    }

    public function getFormattedBirthDateAttribute()
    {
        return $this->birth_date ? $this->birth_date->format('Y年m月d日') : '';
    }

    public function getAgeAttribute()
    {
        return $this->birth_date ? $this->birth_date->age : null;
    }

    public function getYearsOfServiceAttribute()
    {
        return $this->hire_date ? $this->hire_date->diffInYears(now()) : null;
    }

    public function getIsActiveAttribute()
    {
        return $this->status === 'active';
    }
}
