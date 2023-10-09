<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasingInvoice extends Model
{
    use HasFactory;

    protected $fillable = ['order_number','total_price', 'quantity', 'supplier_id'];
    public function supplier()
    {
        return $this->belongsTo(StakeHolder::class);
    }

    public function invoice_items()
    {
        return $this->hasMany(InvoiceItems::class,'invoice_id','id');
    }
}
