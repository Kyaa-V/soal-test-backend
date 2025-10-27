<?php

namespace App\Http\Resources\Vendor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MultipleVendorCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id_vendor"=> $this->id_vendor,
            "kode_vendor"=> $this->kode_vendor,
            "nama_vendor"=> $this->nama_vendor,
            "id_user"=> $this->id_user,
            "items" => ItemResource::collection($this->items) ?? [],
            "created_at"=> $this->created_at,
            "updated_at"=> $this->updated_at,
        ];
    }
}
