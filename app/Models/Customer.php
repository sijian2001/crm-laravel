<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'company',
        'department',
        'position',
        'birth_date',
        'gender',
        'notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function getGenderDisplayAttribute()
    {
        $genders = [
            'male' => '男性',
            'female' => '女性',
            'other' => 'その他',
        ];

        return $genders[$this->gender] ?? '';
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%");
        });
    }
}
