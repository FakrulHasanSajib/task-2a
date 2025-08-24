<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseOrderItem extends Model
{
      use HasFactory;

    protected $fillable = [
        'purchase_order_id', 'product_id', 'brand', 'category', 'code', 'unit',
        'pur_unit_price', 'quantity', 'total_price'
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
}
