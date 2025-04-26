<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderManagementController extends Controller
{
    public function get_ordersManagementPage()
    {
        $orders = Order::with('orderItems')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.modules.orders.index', compact('orders'));
    }

    public function get_orderDetails($order_id)
    {
        $order = Order::with('orderItems.product')->findOrFail($order_id);
        return view('admin.modules.orders.show', compact('order'));
    }

    public function updateOrderStatus(Request $request, $order_id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order = Order::findOrFail($order_id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully');
    }

    public function deleteOrder($order_id)
    {
        $order = Order::findOrFail($order_id);

        // Delete related order items first
        $order->orderItems()->delete();

        // Delete the order
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully');
    }

    public function getOrdersReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Order::query();

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $orders = $query->with('orderItems')->get();

        $totalRevenue = $orders->sum('total_amount');
        $totalOrders = $orders->count();

        return view('admin.modules.orders.report', compact('orders', 'totalRevenue', 'totalOrders', 'startDate', 'endDate'));
    }
}
