<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnsPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'stake_holder_id',
        'r_invoice_id',
        'value',
        'type_return'
    ];

    public function stake_holder()
    {
        return $this->belongsTo(StakeHolder::class,'stake_holder_id','id');
    }


}
