<?php

namespace App\Http\Controllers;

use Razorpay\Api\Api;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class RazorpayController extends Controller
{
    // public function createOrder(Request $request)
    // {
    //     $api = new Api(
    //         config('services.razorpay.key'),
    //         config('services.razorpay.secret')
    //     );

    //     $order = $api->order->create([
    //         'receipt' => 'rcpt_' . time(),
    //         'amount' => $request->amount * 100, // in paise
    //         'currency' => 'INR'
    //     ]);

    //     return response()->json($order);
    // }

    // public function verifyPayment(Request $request)
    // {
    //     $api = new Api(
    //         config('services.razorpay.key'),
    //         config('services.razorpay.secret')
    //     );

    //     try {
    //         $api->utility->verifyPaymentSignature([
    //             'razorpay_order_id' => $request->razorpay_order_id,
    //             'razorpay_payment_id' => $request->razorpay_payment_id,
    //             'razorpay_signature' => $request->razorpay_signature,
    //         ]);

    //         $order = Order::where('order_number', $request->order_number)->first();

    //         $order->update([
    //             'payment_status' => 'paid',
    //             'razorpay_order_id' => $request->razorpay_order_id,
    //             'razorpay_payment_id' => $request->razorpay_payment_id,
    //             'razorpay_signature' => $request->razorpay_signature,
    //         ]);

    //         return redirect()->route('checkout.success', $order->order_number);

    //     } catch (\Exception $e) {
    //         return back()->with('error', 'Payment verification failed');
    //     }
    // }
}
