<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'company_id' => $this->company_id,
            'location' => $this->location,
            'destination' => $this->destination,
            'seller_name' => $this->seller_name,
            'customer_name' => $this->customer_name,
            'customer_notes' => $this->customer_notes,
            'order_status' => $this->order_status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
           
        ];
    }
}
