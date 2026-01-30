<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'featuredProducts' => Product::where('featured', true)
                                        ->where('status', 'active')
                                        ->take(8)
                                        ->get(),

            'bestSellingProducts' => Product::where('best_selling', true)
                                           ->where('status', 'active')
                                           ->take(8)
                                           ->get(),

            'popularProducts' => Product::where('popular', true)
                                       ->where('status', 'active')
                                       ->take(8)
                                       ->get(),

            'latestProducts' => Product::where('latest', true)
                                      ->where('status', 'active')
                                      ->take(8)
                                      ->get(),

            'categories' => Category::where('featured', true)
                                   ->take(6)
                                   ->get(),
        ];

        return view('frontend.home', $data);
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        $relatedProducts = Product::where('category_id', $product->category_id)
                                 ->where('id', '!=', $product->id)
                                 ->where('status', 'active')
                                 ->take(4)
                                 ->get();

        return view('frontend.products.show', compact('product', 'relatedProducts'));
    }
}
