<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{   
    use HasFactory;
    protected $fillable = [
        'property_id', 'tenant_id', 'message',
        'monthly_income', 'move_in_date', 'status', 'landlord_notes',
    ];

    protected $casts = [
        'move_in_date' => 'date',
        'monthly_income' => 'decimal:2',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }
}