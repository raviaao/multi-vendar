<?php

namespace App\Http\Controllers\Admin;  // Root namespace me rakhein

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_products' => Product::count() ?? 0,
            'total_categories' => Category::count() ?? 0,
            'low_stock_products' => 0,
        ];

        $recentProducts = Product::with('category')->latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard.index', compact('stats', 'recentProducts', 'recentUsers'));
    }
}
