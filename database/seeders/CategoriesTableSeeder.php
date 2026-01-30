<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Fruits & Vegetables',
                'slug' => 'fruits-vegetables',
                'order' => 1,
            ],
            [
                'name' => 'Breads & Sweets',
                'slug' => 'breads-sweets',
                'order' => 2,
            ],
            [
                'name' => 'Beverages',
                'slug' => 'beverages',
                'order' => 3,
            ],
            [
                'name' => 'Meat Products',
                'slug' => 'meat-products',
                'order' => 4,
            ],
            [
                'name' => 'Dairy Products',
                'slug' => 'dairy-products',
                'order' => 5,
            ],
            [
                'name' => 'Organic Snacks',
                'slug' => 'organic-snacks',
                'order' => 6,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
