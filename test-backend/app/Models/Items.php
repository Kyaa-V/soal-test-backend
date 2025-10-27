<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    /** @use HasFactory<\Database\Factories\ItemsFactory> */
    use HasFactory;

    protected $table = 'items';
    protected $primaryKey = 'id_item';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'kode_item',
        'nama_item'
    ];

    public function vendorItems(){
        return $this->belongsToMany(Vendor::class, 'vendor_item', 'id_item', 'id_vendor');
    }

    public function orderItems(){
        return $this->hasMany(OrderItems::class, 'id_item', 'id_item');
    }
}
