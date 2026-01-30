<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function place(Request $request)
    {
        $cart = session()->get('cart');

        if (!$cart || count($cart) == 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty');
        }

        // 🔥 ABHI DB SAVE NAHI – DIRECT SUCCESS
        return redirect()->route('order.success');
    }
}
