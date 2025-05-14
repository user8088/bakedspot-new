<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            padding: 20px 0;
            background-color: #FFB9CD;
            color: white;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
        }
        .footer {
            text-align: center;
            padding: 15px;
            font-size: 12px;
            color: #777;
            background-color: #f7f7f7;
            border-radius: 0 0 5px 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f7f7f7;
        }
        .total-row {
            font-weight: bold;
        }
        .order-info {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #FFB9CD;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Thank You for Your Order!</h1>
    </div>

    <div class="content">
        <p>Dear {{ $order->name }},</p>

        <p>Thank you for placing your order with Bakedspot. We're excited to serve you!</p>

        <div class="order-info">
            <h2>Order #{{ $order->id }}</h2>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('F j, Y') }}</p>
            <p><strong>Payment Method:</strong>
                @if($order->sector_id)
                    Cash on Delivery
                @elseif($order->time_slot_id)
                    Payment on Pickup
                @else
                    Cash on Delivery
                @endif
            </p>
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>

            @if($order->sector_id)
                <h3>Delivery Details</h3>
                <p>{{ $order->address }}<br>
                {{ $order->area }}, {{ $order->city }}
                @if($order->postal_code)
                    , {{ $order->postal_code }}
                @endif
                </p>
            @elseif($order->time_slot_id && $order->timeSlot)
                <h3>Pickup Details</h3>
                <p>Pickup Time: {{ date('F j, Y', strtotime($order->pickup_time)) }} at {{ date('h:i A', strtotime($order->timeSlot->start_time)) }}</p>
            @endif

            @if($order->delivery_notes)
                <p><strong>Notes:</strong> {{ $order->delivery_notes }}</p>
            @endif
        </div>

        <h3>Order Summary</h3>
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->pack_type }}</td>
                    <td>PKR {{ number_format($item->price, 2) }}</td>
                </tr>
                @endforeach
                <tr>
                    <td>Subtotal</td>
                    <td>PKR {{ number_format($order->subtotal, 2) }}</td>
                </tr>
                @if($order->sector_id)
                <tr>
                    <td>Delivery Charges</td>
                    <td>PKR {{ number_format($order->delivery_charges, 2) }}</td>
                </tr>
                @endif
                <tr class="total-row">
                    <td>Total</td>
                    <td>PKR {{ number_format($order->total, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <p>If you have any questions about your order, please contact us at <a href="mailto:team@bakedspot.pk">team@bakedspot.pk</a> or call us at <a href="tel:+923111222333">+92-311-1222333</a>.</p>

        <p>Thank you for choosing Bakedspot!</p>

        <p>Best regards,<br>
        The Bakedspot Team</p>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} Bakedspot. All rights reserved.</p>
    </div>
</body>
</html>
