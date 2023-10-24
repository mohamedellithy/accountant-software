<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StakeHolder extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone','role','balance'];

    public function scopeCustomer(){
        return $this->where('role','customer')->orWhereHas('orders');
    }

    public function scopeSupplier(){
        return $this->where('role','supplier')->orWhereHas('products');
    }

    public function orders()
    {
        return $this->hasMany(Order::class,'customer_id','id');
    }

    public function purchasing_invoices()
    {
        return $this->hasMany(PurchasingInvoice::class,'supplier_id','id');
    }

    public function products()
    {
        return $this->hasMany(Product::class,/* 'supplier_id', */'id');
    }

    public function supplier_payments(){
        return $this->hasMany(SupplierPayment::class,'supplier_id','id');
    }

    public function customer_payments(){
        return $this->hasMany(CustomerPayment::class,'customer_id','id');
    }
}
