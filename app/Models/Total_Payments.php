<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Total_Payments extends Model
{
    use HasFactory;
    protected $fillable = ['stake_holder_id','value','debit','credit'];

    public function customer()
    {
        return $this->belongsTo(StakeHolder::class,'stake_holder_id');
    }

}
