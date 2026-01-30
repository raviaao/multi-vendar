<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Display cart
    public function index()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;
        $totalItems = 0;

        foreach ($cart as $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $subtotal += $itemTotal;
            $totalItems += $item['quantity'];
        }

        $shipping = 0; // Free shipping for now
        $tax = 0; // No tax for now
        $total = $subtotal + $shipping + $tax;

        return view('frontend.cart.index', compact('cart', 'subtotal', 'shipping', 'tax', 'total', 'totalItems'));
    }

    // Add item to cart
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check stock
        if ($product->stock_quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Only ' . $product->stock_quantity . ' items available in stock',
            ], 400);
        }

        $cart = session()->get('cart', []);

        // Check if product already in cart
        if (isset($cart[$request->product_id])) {
            $newQuantity = $cart[$request->product_id]['quantity'] + $request->quantity;

            // Check stock again with new quantity
            if ($product->stock_quantity < $newQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot add more than available stock',
                ], 400);
            }

            $cart[$request->product_id]['quantity'] = $newQuantity;
        } else {
            $cart[$request->product_id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->discount_price ?? $product->price,
                'quantity' => $request->quantity,
                'image' => $product->image,
                'slug' => $product->slug,
                'stock' => $product->stock_quantity,
            ];
        }

        session()->put('cart', $cart);

        $cartCount = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart!',
            'cart_count' => $cartCount,
            'cart' => $cart,
        ]);
    }

    // Update cart item quantity
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        if (!isset($cart[$request->product_id])) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found in cart',
            ], 404);
        }

        // Check stock
        if ($product->stock_quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Only ' . $product->stock_quantity . ' items available',
            ], 400);
        }

        $cart[$request->product_id]['quantity'] = $request->quantity;
        session()->put('cart', $cart);

        // Recalculate totals
        $itemTotal = $cart[$request->product_id]['price'] * $request->quantity;
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully',
            'item_total' => number_format($itemTotal, 2),
            'subtotal' => number_format($subtotal, 2),
            'total' => number_format($subtotal, 2),
        ]);
    }

    // Remove item from cart
    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);

            // Recalculate
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            return response()->json([
                'success' => true,
                'message' => 'Product removed from cart',
                'subtotal' => number_format($subtotal, 2),
                'total' => number_format($subtotal, 2),
                'cart_count' => array_sum(array_column($cart, 'quantity')),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product not found in cart',
        ], 404);
    }

    // Clear entire cart
    public function clear()
    {
        session()->forget('cart');

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully',
        ]);
    }

    // Get cart count (for header)
    public function getCount()
    {
        $cart = session()->get('cart', []);
        $count = array_sum(array_column($cart, 'quantity'));

        return response()->json(['count' => $count]);
    }

    // Get cart summary (for checkout)
    public function getSummary()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'items_count' => array_sum(array_column($cart, 'quantity')),
            'subtotal' => number_format($subtotal, 2),
            'total' => number_format($subtotal, 2),
        ]);
    }
}
