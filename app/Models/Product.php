<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product_data';
    protected $guarded = [];

    public function inventory(){
        return $this->hasMany(Inventory::class,'product_id');
    }

     public function purchaseOrderDetail(){
        return $this->hasMany(Inventory::class,'product_id');
    }
}
