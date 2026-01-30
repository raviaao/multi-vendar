<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\PostCategory;
use App\Models\Post;
use Database\Factories\PostCategoryFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create categories
        $categories = Category::factory()->count(10)->create();

        // Create products
        foreach ($categories as $category) {
            Product::factory()->count(5)->create([
                'category_id' => $category->id
            ]);
        }

        // Mark some products as best selling and featured
        Product::inRandomOrder()->take(5)->update(['is_best_selling' => true]);
        Product::inRandomOrder()->take(5)->update(['is_featured' => true]);

        // Create post categories and posts
        $postCategories = PostCategoryFactory::factory()->count(3)->create();

        foreach ($postCategories as $category) {
            PostCategoryFactory::factory()->count(3)->create([
                'category_id' => $category->id
            ]);
        }
    }
}
