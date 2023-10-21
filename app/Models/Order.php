<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\StakeHolder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    
    protected $fillable = ['order_number','sub_total','total_price', 'discount', 'quantity', 'customer_id', 'order_status','payment_type'];
    public function customer()
    {
        return $this->belongsTo(StakeHolder::class);
    }
    public function orderitems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function salesReturns()
    {
        return $this->hasMany(SalesReturn::class);
    }

    public function order_payments(){
        return $this->hasMany(CustomerPayment::class,'s_invoice_id','id');
    }

}
