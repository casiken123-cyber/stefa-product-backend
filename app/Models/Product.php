<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'admin_id', 'name', 'slug', 'description', 'price', 'stock', 'category', 'image_url',
        // Watch strap details
        'lug_width', 'leather_type', 'color', 'buckle', 'length', 'quick_release',
    ];

    protected $casts = [
        'lug_width' => 'integer',
        'quick_release' => 'boolean',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}