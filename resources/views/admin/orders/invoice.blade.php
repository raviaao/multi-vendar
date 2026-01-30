<!DOCTYPE html>
<html>

<head>
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        body {
            background: white;
            color: #333;
            line-height: 1.4;
            padding: 20px;
            font-size: 13px;
        }

        .invoice-wrapper {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 25px;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .company-info h1 {
            color: #2E7D32;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .company-info p {
            color: #666;
            font-size: 12px;
        }

        .invoice-meta {
            text-align: right;
        }

        .invoice-number {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        /* Two Column Layout */
        .columns {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .box {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            border-left: 3px solid #4CAF50;
        }

        .box h3 {
            color: #2E7D32;
            margin-bottom: 10px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            background: #4CAF50;
            color: white;
            border-radius: 3px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Products Table */
        .products {
            margin: 30px 0;
        }

        .products h2 {
            color: #333;
            font-size: 16px;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid #eee;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #2E7D32;
            color: white;
            padding: 12px 10px;
            text-align: left;
            font-weight: 500;
            font-size: 12px;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        .sku {
            font-size: 11px;
            color: #666;
        }

        /* Totals */
        .totals {
            margin-left: auto;
            width: 300px;
            margin-top: 30px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .grand-total {
            font-size: 18px;
            font-weight: bold;
            color: #2E7D32;
            border-top: 2px solid #2E7D32;
            padding-top: 10px;
            margin-top: 5px;
        }

        /* Footer */
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .qr-code {
            text-align: center;
            padding: 10px;
            border: 1px solid #eee;
            background: white;
        }

        .qr-code img {
            width: 100px;
            height: 100px;
        }

        .qr-code p {
            font-size: 11px;
            margin-top: 5px;
            color: #666;
        }

        /* Print Styles */
        @media print {
            body {
                padding: 0;
            }

            .invoice-wrapper {
                max-width: 100%;
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-wrapper">
        <!-- Header -->
        <div class="header">
            <div class="company-info" style="text-align: left; margin-bottom: 20px; font-family: Arial, sans-serif;">
                <h1 style="font-size: 24px; color: #2c3e50; margin-bottom: 5px;">Organic Store</h1>
                <p style="margin: 0; font-size: 14px; color: #555;">Noida Sector 62, Eco Park, Green City, ZIP 201301
                </p>
                <p style="margin: 2px 0 0 0; font-size: 14px; color: #555;">
                    <strong>Phone:</strong> +91 87439 16453 &nbsp; | &nbsp;
                    <strong>Email:</strong> <a href="mailto:orders@organicstore.com"
                        style="color: #2980b9; text-decoration: none;">orders@organicstore.com</a>
                </p>
            </div>

            <div class="invoice-meta">
                <div class="invoice-number">INVOICE #{{ $order->order_number }}</div>
                <p><strong>Date:</strong> {{ date('F d, Y', strtotime($order->created_at)) }}</p>
                <p><strong>Due Date:</strong> {{ date('F d, Y', strtotime('+7 days')) }}</p>
            </div>
        </div>

        <!-- Two Column Layout -->
        <div class="columns">
            <div class="box">
                <h3>Bill To</h3>
                <p><strong>{{ $order->full_name }}</strong></p>
                <p>{{ $order->email }}</p>
                <p>{{ $order->address_full }}</p>
            </div>

            <div class="box">
                <h3>Order Details</h3>
                <p><strong>Status:</strong> <span class="status-badge">{{ ucfirst($order->order_status) }}</span></p>
                <p><strong>Payment Method:</strong> {{ $order->payment_method ?? 'Credit Card' }}</p>
                <p><strong>Order Date:</strong> {{ date('F d, Y', strtotime($order->created_at)) }}</p>
            </div>
        </div>

        <!-- Products Table -->
        <div class="products">
            <h2>Order Items</h2>
            <table>
                <thead>
                    <tr>
                        <th width="40%">Product</th>
                        <th width="15%">Qty</th>
                        <th width="20%">Unit Price</th>
                        <th width="25%">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td>
                                {{ $item->product->name }}
                                <div class="sku">SKU: {{ $item->product->sku ?? 'ORG' . $item->product_id }}</div>
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td><strong>${{ number_format($item->total, 2) }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totals -->
        <div class="totals">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>${{ number_format($order->subtotal, 2) }}</span>
            </div>
            <div class="total-row">
                <span>Shipping:</span>
                <span>${{ number_format($order->shipping, 2) }}</span>
            </div>
            <div class="total-row">
                <span>Tax:</span>
                <span>${{ number_format($order->tax, 2) }}</span>
            </div>
            @if (isset($order->discount) && $order->discount > 0)
                <div class="total-row">
                    <span>Discount:</span>
                    <span style="color: #d32f2f;">-${{ number_format($order->discount, 2) }}</span>
                </div>
            @endif
            <div class="total-row grand-total">
                <span>TOTAL:</span>
                <span>${{ number_format($order->total, 2) }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div>
                <p><strong>Notes:</strong></p>
                <p>Thank you for your order. Payment is due within 7 days.</p>
                <p>All products are 100% organic and guaranteed.</p>
            </div>

            <div class="qr-code">
                <!-- QR Code Generator - Using Google Charts API -->
                <img src="https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=ORDER-{{ $order->order_number }}&choe=UTF-8"
                    alt="Order QR Code">
                <p>Scan for order details</p>
            </div>
        </div>
    </div>
</body>

</html>
