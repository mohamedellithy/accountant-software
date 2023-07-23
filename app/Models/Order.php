<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['order_number', 'total_price', 'discount', 'product_count', 'customer_id', 'order_status'];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function orderitems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function salesReturns()
    {
        return $this->hasMany(SalesReturn::class);
    }

}
