<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'id_number',
        'phone',
        'father_name',
        'mother_name',
        'spouse_name',
        'email',
        'address',
        'document_type',
        'document_path',
    ];
}
