<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'quantity', 'purchasing_price','sale_price', 'supplier_id'];

    public function supplier()
    {
        return $this->belongsTo(StakeHolder::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function orderitems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
