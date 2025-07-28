<?php

namespace App\Models\Inbound;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetail extends Model
{
    use HasFactory;
    protected $table = 'purchase_order_detail';
    protected $guarded = [];
    public function purchaseOrder(){
        return $this->belongsTo(PurchaseOrder::class,'supplier_id');
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    
}
