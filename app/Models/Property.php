<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'address', 'monthly_rent',
        'bedrooms', 'description', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'monthly_rent' => 'decimal:2',
    ];

    public function landlord()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}