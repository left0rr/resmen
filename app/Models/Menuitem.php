<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menuitem extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'image_url',  // Ensure this is fillable
    ];

// Optionally, set default values if necessary
    protected $attributes = [
        'image_url' => 'default_image_url_here',  // Set a default URL if needed
    ];


    use HasFactory;
    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
