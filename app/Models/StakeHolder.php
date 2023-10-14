<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StakeHolder extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone','role'];

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

    public function products()
    {
        return $this->hasMany(Product::class,/* 'supplier_id', */'id');
    }
}
