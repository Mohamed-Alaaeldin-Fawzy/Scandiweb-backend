<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Model\Product;

class Gallery extends Model
{
    protected $table = 'gallery';

    protected $fillable = [
        'product_id',
        'image_url',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
