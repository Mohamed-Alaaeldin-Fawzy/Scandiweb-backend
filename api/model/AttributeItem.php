<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Model\Attributes;

class AttributeItem extends Model
{
    protected $table = 'attribute_items';

    protected $fillable = [
        'display_value',
        'value',
    ];

    public function attributes(): BelongsTo
    {
        return $this->belongsTo(Attributes::class, 'attribute_id');
    }
}