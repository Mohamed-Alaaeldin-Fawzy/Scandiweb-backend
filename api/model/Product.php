<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Model\Attributes;
use Model\Category;
use Model\Gallery;
use Model\Prices;

class Product extends Model {
    protected $table = 'products';
    protected $fillable = ['id', 'name', 'in_stock', 'description', 'category_id', 'brand'];

    public $incrementing = false;
    protected $keyType = 'string';

    
    public function category(): BelongsTo {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function prices(): HasMany {
        return $this->hasMany(Prices::class, 'product_id');
    }

    public function attributes(): HasMany {
        return $this->hasMany(Attributes::class, 'product_id');
    }

    public function gallery(): HasMany {
        return $this->hasMany(Gallery::class, 'product_id');
    }
}
