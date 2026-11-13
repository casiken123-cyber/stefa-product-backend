<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['admin_id', 'name', 'slug', 'description', 'price', 'stock', 'category', 'image_url'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}