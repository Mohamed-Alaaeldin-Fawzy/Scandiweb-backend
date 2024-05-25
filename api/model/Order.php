<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Model\OrderItem;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'id',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
}