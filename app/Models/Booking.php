<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    // Fillable properties for mass assignment
    protected $fillable = [
        'apartment_id',
        'tenant_id',
        'start_date',
        'end_date',
        'payment_status',
        'parking_charge',
        'other_charges',
    ];

    // Default attributes
    protected $attributes = [
        'payment_status' => 'unpaid', // Default payment status
        'parking_charge' => 0,         // Default parking charge (as integer)
        'other_charges' => 0,          // Default other charges (as integer)
    ];

    // Relationships
    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
