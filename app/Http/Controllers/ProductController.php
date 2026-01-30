<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Routing\Controller;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'active')
                          ->latest()
                          ->paginate(12);

        $categories = Category::all();

        return view('frontend.products.show', compact('products', 'categories'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
                         ->where('status', 'active')
                         ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
                                 ->where('id', '!=', $product->id)
                                 ->where('status', 'active')
                                 ->take(4)
                                 ->get();

        return view('frontend.products.show', compact('product', 'relatedProducts'));
    }

    public function featured()
    {
        $products = Product::where('featured', true)
                          ->where('status', 'active')
                          ->paginate(12);

        return view('frontend.products.featured', compact('products'));
    }

    public function bestSelling()
    {
        $products = Product::where('best_selling', true)
                          ->where('status', 'active')
                          ->paginate(12);

        return view('frontend.products.best-selling', compact('products'));
    }

    public function popular()
    {
        $products = Product::where('popular', true)
                          ->where('status', 'active')
                          ->paginate(12);

        return view('frontend.products.popular', compact('products'));
    }

    public function latest()
    {
        $products = Product::where('latest', true)
                          ->where('status', 'active')
                          ->paginate(12);

        return view('frontend.products.latest', compact('products'));
    }
}
