<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'guard_salary',
        'electricity_bill',
        'monjil_gas_guard_bill',
        'other_expenses',
    ];

    protected $casts = [
        'other_expenses' => 'array',
    ];
}
