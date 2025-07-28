<?php

namespace App\Models\Inbound;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class GoodsReceipt extends Model
{
    protected $table = 'goods_receipt';
    protected $guarded = [];

    public function purchaseOrder(){
        return $this->belongsTo(PurchaseOrder::class,'purchase_order_id','purchase_order_id');
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

}
