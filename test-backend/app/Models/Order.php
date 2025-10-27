<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_order';

    public $incrementing = true; 

    protected $keyType = 'int';

    protected $fillable =[
        'tgl_order',
        'no_order',
        'total_order',
        'status_order',
        'id_user'
    ]; 

    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function orderItems(){
        return $this->hasMany(OrderItems::class, 'id_order', 'id_order');
    }
}
