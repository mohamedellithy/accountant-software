<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPayment extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id','s_invoice_id','value'];

    public function order()
    {
        return $this->belongsTo(Order::class,'s_invoice_id','id');
    }
}

