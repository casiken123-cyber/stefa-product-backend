<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'admin_id' => $this->admin_id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'category' => $this->category,
            // Watch strap details
            'lug_width' => $this->lug_width,
            'leather_type' => $this->leather_type,
            'color' => $this->color,
            'buckle' => $this->buckle,
            'length' => $this->length,
            'quick_release' => (bool) $this->quick_release,
            'image_url' => $this->image_url
                ? (str_starts_with($this->image_url, 'http') ? $this->image_url : url($this->image_url))
                : null,
            'created_at' => $this->created_at,
        ];
    }
}