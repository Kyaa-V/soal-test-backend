<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class VendorItems extends Pivot
{
    use HasFactory;
    
    protected $fillable = [
        'id_vendor',
        'id-item',
        'harga_sebelumnya',
        'harga_sekarang'
    ];
}
