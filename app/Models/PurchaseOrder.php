<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = ['order_no', 'date', 'supplier_id', 'total', 'paid', 'due', 'status', 'notes'];

    // এটি একটি PurchaseOrder এর সাথে কোন Supplier যুক্ত আছে তা নির্দেশ করে।
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function items()
{
    return $this->hasMany(PurchaseOrderItem::class);
}
}