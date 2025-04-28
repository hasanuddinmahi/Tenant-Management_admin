<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use HasFactory, SoftDeletes;
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
