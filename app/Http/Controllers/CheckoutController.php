<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Routing\Controller;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ================= CHECKOUT PAGE =================
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $subtotal = collect($cart)->sum(fn ($i) => $i['price'] * $i['quantity']);
        $shipping = $subtotal >= 1000 ? 0 : 100;
        $tax = 0;
        $total = $subtotal + $shipping + $tax;

        $user = Auth::user(); // 🔥 VERY IMPORTANT

        return view('frontend.checkout.index', compact(
            'cart',
            'subtotal',
            'shipping',
            'tax',
            'total',
            'user'
        ));
    }

    // ================= RAZORPAY ORDER CREATE =================
    public function createRazorpayOrder()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return response()->json(['message' => 'Cart empty'], 400);
        }

        $subtotal = collect($cart)->sum(fn ($i) => $i['price'] * $i['quantity']);
        $shipping = $subtotal >= 1000 ? 0 : 100;
        $total = $subtotal + $shipping;

        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        $razorpayOrder = $api->order->create([
            'receipt' => 'order_' . time(),
            'amount' => $total * 100, // paise
            'currency' => 'INR'
        ]);

        return response()->json([
            'order_id' => $razorpayOrder->id,
            'amount'   => $total,
            'key'      => config('services.razorpay.key'),
        ]);
    }

    // ================= PLACE ORDER =================
   public function store(Request $request)
{
    $request->validate([
        'first_name'     => 'required|string|max:100',
        'last_name'      => 'required|string|max:100',
        'email'          => 'required|email',
        'phone'          => 'required',
        'address'        => 'required',
        'city'           => 'required',
        'state'          => 'required',
        'zip_code'       => 'required',
       'payment_method' => 'required|string',

    ]);

    $cart = session()->get('cart', []);
    if (empty($cart)) {
        return redirect()->route('cart.index');
    }

    $subtotal = collect($cart)->sum(fn ($i) => $i['price'] * $i['quantity']);
    $shipping = $subtotal >= 1000 ? 0 : 100;
    $tax = 0;
    $total = $subtotal + $shipping + $tax;

    // 🔐 Razorpay Verify
    if ($request->payment_method === 'razorpay') {
        try {
            $api = new Api(
                config('services.razorpay.key'),
                config('services.razorpay.secret')
            );

            $api->utility->verifyPaymentSignature([
                'razorpay_order_id'   => $request->razorpay_order_id,
                'razorpay_payment_id'=> $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Payment verification failed');
        }
    }

    $order = Order::create([
        'order_number'   => 'ORD-' . strtoupper(uniqid()),
        'user_id'        => Auth::id(),
        'first_name'     => $request->first_name,
        'last_name'      => $request->last_name,
        'email'          => $request->email,
        'phone'          => $request->phone,
        'address'        => $request->address,
        'city'           => $request->city,
        'state'          => $request->state,
        'zip_code'       => $request->zip_code,
        'payment_method' => $request->payment_method,
        'payment_status' => $request->payment_method === 'cod' ? 'pending' : 'paid',
        'order_status'   => 'pending',
        'subtotal'       => $subtotal,
        'shipping'       => $shipping,
        'tax'            => $tax,
        'total'          => $total,
    ]);

    foreach ($cart as $item) {
        OrderItem::create([
            'order_id'     => $order->id,
            'product_id'   => $item['id'],
            'product_name' => $item['name'],
            'price'        => $item['price'],
            'quantity'     => $item['quantity'],
            'total'        => $item['price'] * $item['quantity'],
        ]);

        Product::where('id', $item['id'])
            ->decrement('stock_quantity', $item['quantity']);
    }

    session()->forget('cart');

    return redirect()
        ->route('checkout.success', $order->order_number)
        ->with('success', 'Order placed successfully');
}

    // ================= SUCCESS PAGE =================
   public function success($orderNumber)
{
    $order = Order::with('items')->where('order_number', $orderNumber)->firstOrFail();
    return view('frontend.checkout.success', compact('order'));
}

}
