<?php

namespace App\Models;

use App\Models\Product;
use App\Models\StakeHolder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends StakeHolder
{
    use HasFactory;
    protected $fillable=['name','phone'];

}
