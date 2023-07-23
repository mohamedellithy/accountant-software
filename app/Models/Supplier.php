<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable=['name','phoneNumber'];
     public function products()
    {
        return $this->hasMany(Product::class);
    }
}
