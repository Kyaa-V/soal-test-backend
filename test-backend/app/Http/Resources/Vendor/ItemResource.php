<?php

namespace App\Http\Resources\Vendor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id_item" => $this->id_item,
            "kode_item" => $this->kode_item,
            "nama_item" => $this->nama_item,
            "pivot" => [
                "harga_sebelumnya" => $this->pivot->harga_sebelumnya ?? null,
                "harga_sekarang" => $this->pivot->harga_sekarang ?? null,
            ],
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
