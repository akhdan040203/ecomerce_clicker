<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => (float) $this->price,
            'formatted_price' => 'Rp ' . number_format($this->price, 0, ',', '.'),
            'stock' => $this->stock,
            'image' => $this->image 
                ? (\Illuminate\Support\Str::startsWith($this->image, 'http') ? $this->image : asset('storage/' . $this->image))
                : null,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'created_at' => $this->created_at,
        ];
    }
}
