<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'product' => new ProductResource($this->product),
            'quantity' => (int) $this->quantity,
            'subtotal' => $this->product->price * $this->quantity,
            'formatted_subtotal' => 'Rp ' . number_format($this->product->price * $this->quantity, 0, ',', '.'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
