<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    /** @use HasFactory<\Database\Factories\VendorFactory> */
    use HasFactory;

    protected $fillable = [
        'kode_vendor',
        'nama_vendor',
        'id_user'
    ];
    
    protected $table = 'vendors';
    protected $primaryKey = 'id_vendor';
    public $incrementing = true;
    protected $keyType = 'int';

    public function user() {
        return $this->belongsTo(User::class);
    }   

    public function items(){
        return $this->belongsToMany(Items::class, 'vendor_item', 'id_vendor', 'id_item');
    }

}
