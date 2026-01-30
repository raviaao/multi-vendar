<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class OrderController extends Controller
{
    // Display all orders
    public function index()
    {
        $orders = Order::with(['user', 'items.product'])
                       ->orderBy('created_at', 'desc')
                       ->paginate(15);

        $totalOrders = Order::count();
        $pendingCount = Order::where('order_status', 'pending')->count();
        $processingCount = Order::where('order_status', 'processing')->count();
        $shippedCount = Order::where('order_status', 'shipped')->count();
        $deliveredCount = Order::where('order_status', 'delivered')->count();
        $cancelledCount = Order::where('order_status', 'cancelled')->count();

        return view('admin.orders.index', compact(
            'orders',
            'totalOrders',
            'pendingCount',
            'processingCount',
            'shippedCount',
            'deliveredCount',
            'cancelledCount'
        ));
    }

    // Filter orders by status
    public function filter($status)
    {
        $validStatuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];

        if (!in_array($status, $validStatuses)) {
            return redirect()->route('admin.orders.index');
        }

        $orders = Order::with(['user', 'items.product'])
                       ->where('order_status', $status)
                       ->orderBy('created_at', 'desc')
                       ->paginate(15);

        $totalOrders = Order::count();
        $pendingCount = Order::where('order_status', 'pending')->count();
        $processingCount = Order::where('order_status', 'processing')->count();
        $shippedCount = Order::where('order_status', 'shipped')->count();
        $deliveredCount = Order::where('order_status', 'delivered')->count();
        $cancelledCount = Order::where('order_status', 'cancelled')->count();

        return view('admin.orders.index', compact(
            'orders',
            'totalOrders',
            'pendingCount',
            'processingCount',
            'shippedCount',
            'deliveredCount',
            'cancelledCount',
            'status'
        ));
    }

    // Show specific order details
    public function show($id)
    {
        $order = Order::with(['user', 'items.product'])
                      ->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    // Edit order
    public function edit($id)
    {
        $order = Order::with(['user', 'items.product'])
                      ->findOrFail($id);

        $statuses = [
            'pending' => 'Pending',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled'
        ];

        $paymentStatuses = [
            'pending' => 'Pending',
            'paid' => 'Paid',
            'failed' => 'Failed',
            'refunded' => 'Refunded'
        ];

        return view('admin.orders.edit', compact('order', 'statuses', 'paymentStatuses'));
    }

    // Update order
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'tracking_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        $order = Order::findOrFail($id);

        $order->update([
            'order_status' => $request->status,
            'payment_status' => $request->payment_status,
            'tracking_number' => $request->tracking_number,
            'notes' => $request->notes,
        ]);

        // If order is cancelled, restore product stock
        if ($request->status == 'cancelled' && $order->order_status != 'cancelled') {
            foreach ($order->items as $item) {
                $item->product->increment('stock_quantity', $item->quantity);
            }
        }

        return redirect()->route('admin.orders.show', $order->id)
                         ->with('success', 'Order updated successfully.');
    }

    // Delete order
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        if (!in_array($order->order_status, ['pending', 'cancelled'])) {
            return redirect()->back()->with('error', 'Cannot delete order with status: ' . $order->order_status);
        }

        $order->delete();

        return redirect()->route('admin.orders.index')
                         ->with('success', 'Order deleted successfully.');
    }

    // Add item to existing order
    public function addItem(Request $request, $orderId)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $order = Order::findOrFail($orderId);
        $product = Product::findOrFail($request->product_id);

        if ($product->stock_quantity < $request->quantity) {
            return redirect()->back()->with('error', 'Insufficient stock. Available: ' . $product->stock_quantity);
        }

        OrderItem::create([
            'order_id' => $orderId,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'total' => $request->quantity * $request->price,
        ]);

        $product->decrement('stock_quantity', $request->quantity);

        $this->updateOrderTotal($order);

        return redirect()->back()->with('success', 'Item added to order successfully.');
    }

    // Update order item
    public function updateItem(Request $request, $orderId, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $orderItem = OrderItem::where('order_id', $orderId)
                             ->where('id', $itemId)
                             ->firstOrFail();

        $oldQuantity = $orderItem->quantity;
        $newQuantity = $request->quantity;

        $orderItem->update([
            'quantity' => $newQuantity,
            'price' => $request->price,
            'total' => $newQuantity * $request->price,
        ]);

        $order = Order::findOrFail($orderId);
        $this->updateOrderTotal($order);

        if ($oldQuantity != $newQuantity) {
            $difference = $newQuantity - $oldQuantity;
            if ($difference > 0) {
                $orderItem->product->decrement('stock_quantity', $difference);
            } else {
                $orderItem->product->increment('stock_quantity', abs($difference));
            }
        }

        return redirect()->back()->with('success', 'Order item updated successfully.');
    }

    // Remove item from order
    public function removeItem($orderId, $itemId)
    {
        $orderItem = OrderItem::where('order_id', $orderId)
                             ->where('id', $itemId)
                             ->firstOrFail();

        $orderItem->product->increment('stock_quantity', $orderItem->quantity);

        $orderItem->delete();

        $order = Order::findOrFail($orderId);
        $this->updateOrderTotal($order);

        return redirect()->back()->with('success', 'Item removed from order.');
    }

    // Download invoice
  public function invoice($id)
{
    $order = Order::with(['user', 'items.product'])->findOrFail($id);

    $pdf = Pdf::loadView('admin.orders.invoice', compact('order'));
    return $pdf->download('Invoice-'.$order->order_number.'.pdf');
}

    // Export orders
    public function export(Request $request)
    {
        $orders = Order::with(['user', 'items.product'])->orderBy('created_at', 'desc')->get();

        return response()->json(['message' => 'Export feature coming soon']);
    }

    // ================= Helper: Update order total =================
    private function updateOrderTotal($order)
    {
        $subtotal = $order->items()->sum('total');
        $tax = $subtotal * 0.18; // 18% GST
        $total = $subtotal + $order->shipping + $tax;

        $order->update([
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
        ]);
    }
}
