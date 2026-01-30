<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{
    /**
     * Show all categories
     */
    public function index()
    {
        $categories = Category::withCount(['products'])
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('frontend.categories.index', compact('categories'));
    }

    /**
     * Show single category with its products
     */
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->first();

        if (!$category) {
            abort(404);
        }

        $products = Product::where('category_id', $category->id)
            ->where('is_active', true)
            ->paginate(12);

        return view('frontend.categories.show', compact('category', 'products'));
    }
}
