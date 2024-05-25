<?php

namespace Resolver;

use Repository\Category as CategoryRepository;

class Category {
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories(): array {
        $categories = $this->categoryRepository->getAllCategories();
        $data = [];
        foreach ($categories as $category) {
            $data[] = [
                'id' => $category->id,
                'name' => $category->name,
            ];
        }
        return $data;
    }

}
