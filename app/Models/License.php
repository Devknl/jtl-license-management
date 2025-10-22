<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'license_key',
        'customer_name',
        'product_name',
        'valid_until',
        'status',
        'license_type'
    ];

    protected $casts = [
        'valid_until' => 'date',
    ];
}