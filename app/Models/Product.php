<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable  = [
        'product_name',
        'supplier_id',
        'category_id',
        'brand_id',
        'purchase_price',
        'selling_price',
        'qty',
        'purchase_date',
        'expair_date',
        'image',
        'created_at'   
    ];
}
