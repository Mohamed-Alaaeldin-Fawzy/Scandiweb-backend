<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Model\Product;

class Prices extends Model
{
    protected $table = 'prices';

    protected $fillable = [
        'product_id',
        'amount',
        'currency',
        'currency_symbol',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
