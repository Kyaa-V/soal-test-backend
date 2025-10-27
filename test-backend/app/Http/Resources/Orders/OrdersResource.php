<?php

namespace App\Http\Resources\Orders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id_order"=> $this->id_order,
            "tgl_order"=> $this->tgl_order,
            "no_order"=> $this->no_order,
            "total_order"=> $this->total_order,
            "status_order"=> $this->status_order,
            "created_at"=> $this->created_at,
            "updated_at"=> $this->updated_at,   
            "order_items" => $this->order_item
            // "order_items"=> OrdersItemsResource::collection($this->order_items->items()) ?? []
        ];
    }
}
