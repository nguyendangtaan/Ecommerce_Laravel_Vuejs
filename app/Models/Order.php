<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'address',
        'email',
        'cart_items', // Assuming cart_items is stored as JSON
    ];
    protected $casts = [
        'cart_items' => 'array', // Cast cart_items to array for easy access
    ];  
    
}