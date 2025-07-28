<?php

namespace App\Models\Inbound;
use App\Models\Inbound\PurchaseOrderDetail;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $table = 'purchase_order';
    protected $guarded = [];
    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id');
    }
    
    public function purchaseOrderDetail(){
        return $this->hasMany(PurchaseOrderDetail::class,'purchase_order_id','purchase_order_id');
    }



}
