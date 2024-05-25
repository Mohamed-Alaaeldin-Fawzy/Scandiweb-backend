<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;
use Model\Product;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'id',
        'name',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}