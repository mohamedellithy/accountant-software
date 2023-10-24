<?php

namespace App\Models;

use App\Models\Supplier;
use App\Models\OrderItem;
use App\Models\StakeHolder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function stock(){
        return $this->hasOne(Stock::class);
    }

    public function order_items(){
        return $this->hasMany(OrderItem::class,'product_id','id');
    }

    public function invoice_items(){
        return $this->hasMany(InvoiceItems::class,'product_id','id');
    }

}
