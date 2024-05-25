<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Model\Product;
use Model\AttributeItem;

class Attributes extends Model
{
    protected $table = 'attributes';

    protected $fillable = [
        'name',
        'type',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function items(): HasMany
    {
        return $this->hasMany(AttributeItem::class, 'attribute_id', 'id');
    }
    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
