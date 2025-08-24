<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Brand;


class PurchaseDetail extends Model
{
      use HasFactory;

    protected $fillable = [
        'purchase_id',
        'product_id',
        'brand_id',
        'category_id',
        'unit_id',
        'pur_unit_price',
        'quantity',
        'total_price',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
