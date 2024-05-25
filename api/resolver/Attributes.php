<?php

namespace Resolver;

use Repository\mysql\Attributes as AttributesRepository;

class Attributes {
    private AttributesRepository $attributesRepository;

    public function __construct(AttributesRepository $attributesRepository) {
        $this->attributesRepository = $attributesRepository;
    }

    public function getAllAttributes(): array {
        $attributes = $this->attributesRepository->getAllAttributes();
        $data = [];
        foreach ($attributes as $attribute) {
            $data[] = [
                'id' => $attribute->id,
                'name' => $attribute->name,
                'type' => $attribute->type,
                'items' => $attribute->items
            ];
        }
        return $data;
    }
}
