<?php

namespace App\Models;

use App\Models\Supplier;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'quantity', 'price', 'supplier_id'];
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
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
