<?php

namespace App\Models\Inbound;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;

class InboundDetail extends Model
{
    protected $table = 'inbound_detail';
    protected $guarded = [];

    public function purchaseOrder(){
        return $this->belongsTo(PurchaseOrder::class,'purchase_order_id','purchase_order_id');
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id');
    }

}
