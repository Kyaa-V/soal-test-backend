<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItems extends Model
{
    use HasFactory;

    protected $fillable =[
        'id_order',
        'id_item',
        'jumlah_item',
        'harga_item'
    ];

    public function order(){
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }

    public function items(){
        return $this->belongsTo(Items::class, 'id_item', 'id_item');
    }
}
