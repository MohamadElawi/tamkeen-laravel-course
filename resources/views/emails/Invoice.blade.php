<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 30px;
            background-color: #f9f9f9;
            color: #333;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            background: #fff;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }
        .invoice-box h1 {
            font-size: 32px;
            margin-bottom: 0;
        }
        .invoice-box p {
            margin: 4px 0;
        }
        .info-section {
            margin-bottom: 30px;
        }
        .info-title {
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            margin-top: 20px;
        }
        table thead {
            background-color: #f0f0f0;
        }
        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .total {
            text-align: right;
            font-weight: bold;
            font-size: 16px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            font-size: 13px;
            color: #777;
            margin-top: 40px;
        }
    </style>
</head>
<body>
<div class="invoice-box">
    <div style="text-align: center; margin-bottom: 20px;">
        <h1>Order Invoice</h1>
        <p><strong>Invoice #{{ $order->order_number }}</strong></p>
        <p>Date: {{ $order->created_at->format('F d, Y') }}</p>
    </div>

    <div class="info-section">
        <div class="info-title">Customer Information</div>
        <p><strong>Name:</strong> {{ $order->user->name }}</p>
        <p><strong>Email:</strong> {{ $order->user->email }}</p>
        <p><strong>Address:</strong> {{ 'Syria, Damascus' }}</p>
    </div>

    <div class="info-section">
        <div class="info-title">Order Details</div>
        <table>
            <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Unit Price</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($order->orderProducts as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <p class="total">
        Total: ${{ number_format($order->orderProducts->sum(fn($item) => $item->price * $item->quantity), 2) }}
    </p>

    <div class="footer">
        <p>Thank you for your purchase!</p>
        <p>For questions, contact support@example.com</p>
    </div>
</div>
</body>
</html>
