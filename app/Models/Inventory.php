<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    use HasFactory;
    protected $table = 'inventory';
    protected $guarded = [];

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
