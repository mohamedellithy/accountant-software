<?php

namespace App\Models;

use App\Models\SupplierPayment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchasingInvoice extends Model
{
    use HasFactory;

    protected $fillable = ['order_number','total_price', 'quantity', 'supplier_id','payment_type'];
    public function supplier()
    {
        return $this->belongsTo(StakeHolder::class);
    }

    public function invoice_items()
    {
        return $this->hasMany(InvoiceItems::class,'invoice_id','id');
    }

    public function invoice_payments(){
        return $this->hasMany(SupplierPayment::class,'p_invoice_id','id');
    }
}
