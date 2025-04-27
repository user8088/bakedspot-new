<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Orders Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }
        .header h1 {
            margin: 0;
            padding: 0;
            font-size: 22px;
            color: #333;
        }
        .summary {
            margin-bottom: 20px;
        }
        .summary-box {
            float: left;
            width: 23%;
            margin-right: 2%;
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
            margin-bottom: 15px;
        }
        .summary-box h3 {
            margin: 0;
            padding: 0;
            font-size: 14px;
        }
        .summary-box p {
            margin: 5px 0 0;
            padding: 0;
            font-size: 22px;
            font-weight: bold;
        }
        .pending { border-left: 4px solid #ffc107; }
        .processing { border-left: 4px solid #17a2b8; }
        .completed { border-left: 4px solid #28a745; }
        .cancelled { border-left: 4px solid #dc3545; }
        .total { border-left: 4px solid #007bff; }
        .revenue { border-left: 4px solid #28a745; }

        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            text-align: center;
            color: #777;
        }
        .text-muted {
            color: #777;
            font-size: 11px;
        }
        .date-range {
            font-size: 14px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Orders Report</h1>
            <div class="date-range">
                Period: {{ $start_date }} to {{ $end_date }}
                @if($status != 'all')
                | Status: {{ ucfirst($status) }} Orders
                @endif
            </div>
        </div>

        <div class="summary clearfix">
            <div class="summary-box total">
                <h3>Total Orders</h3>
                <p>{{ $totalOrders }}</p>
            </div>
            <div class="summary-box revenue">
                <h3>Total Revenue</h3>
                <p>PKR {{ number_format($totalRevenue, 2) }}</p>
            </div>
        </div>

        <div class="summary clearfix">
            <div class="summary-box pending">
                <h3>Pending</h3>
                <p>{{ $ordersByStatus['pending'] }}</p>
            </div>
            <div class="summary-box processing">
                <h3>Processing</h3>
                <p>{{ $ordersByStatus['processing'] }}</p>
            </div>
            <div class="summary-box completed">
                <h3>Completed</h3>
                <p>{{ $ordersByStatus['completed'] }}</p>
            </div>
            <div class="summary-box cancelled">
                <h3>Cancelled</h3>
                <p>{{ $ordersByStatus['cancelled'] }}</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Time Slot</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Payment</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>
                        {{ $order->name ?? 'Guest' }}
                        <div class="text-muted">{{ $order->email ?? 'No email' }}</div>
                    </td>
                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                    <td>
                        @if($order->timeSlot)
                            {{ $order->timeSlot->start_time }} - {{ $order->timeSlot->end_time }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>PKR {{ number_format($order->total, 2) }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>
                        {{ $order->payment_status ? 'Paid' : 'Pending' }}
                        <div class="text-muted">{{ ucfirst($order->payment_method) }}</div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center">No orders found matching the criteria</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            Report generated on {{ now()->format('F d, Y H:i:s') }}
        </div>
    </div>
</body>
</html>
