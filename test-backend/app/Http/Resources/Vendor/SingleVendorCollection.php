<?php

namespace App\Http\Resources\Vendor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SingleVendorCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toResponse($request)
    {
        return response()->json([
            "id_vendor"=> $this->id_vendor,
            "kode_vendor"=> $this->kode_vendor,
            "nama_vendor"=> $this->nama_vendor,
            "id_user"=> $this->id_user,
            "item" => new ItemResource($this->items),
            "created_at"=> $this->created_at,
            "updated_at"=> $this->updated_at,
        ]);
    }
}
