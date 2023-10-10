<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerReturn extends Model
{
    use HasFactory;

    protected $fillable = ['order_number','customer_id','total_price'];

    public function customer()
    {
        return $this->belongsTo(StakeHolder::class);
    }

    public function returnitems()
    {
        return $this->hasMany(ReturnItem::class,'return_id');
    }

}
