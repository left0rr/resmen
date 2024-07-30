<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class MenuitemOrderCount extends Model
{
    use HasFactory;

    protected $fillable = ['menuitem_id', 'times_ordered'];
}
