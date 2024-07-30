<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['table', 'details', 'served', 'discount'];

    protected $casts = [
        'details' => 'json', // This allows automatic encoding and decoding
        'served'=>'boolean'
    ];
}
