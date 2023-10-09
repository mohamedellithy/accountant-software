<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItems extends Model
{
    use HasFactory;

    protected $fillable = ['qty', 'price','product_id','invoice_id'];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function purchasing_invoice()
    {
        return $this->belongsTo(PurchasingInvoice::class,'invoice_id','id');
    }
}
