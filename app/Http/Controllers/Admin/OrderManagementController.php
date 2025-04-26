<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Models\TimeSlot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class OrderManagementController extends Controller
{
    /**
     * Display a listing of the orders.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'timeSlot']);

        // Apply filters
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sort by most recent first
        $query->orderBy('created_at', 'desc');

        // Paginate the results
        $orders = $query->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::with(['orderItems.product', 'user', 'timeSlot'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the specified order status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;

        // Update payment status if provided
        if ($request->has('payment_status')) {
            $order->payment_status = $request->payment_status;
        }

        if ($order->save()) {
            return redirect()->route('admin.orders.show', $id)
                ->with('success', 'Order status updated successfully');
        }

        return back()->with('error', 'Failed to update order status');
    }

    /**
     * Remove the specified order from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        try {
            DB::beginTransaction();

            // Delete associated order items
            $order->orderItems()->delete();

            // Delete the order
            $order->delete();

            DB::commit();

            return redirect()->route('admin.orders.index')
                ->with('success', 'Order deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting order: ' . $e->getMessage());

            return back()->with('error', 'Failed to delete order. Please try again.');
        }
    }

    /**
     * Generate a report of orders.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generateReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:all,pending,processing,completed,cancelled',
        ]);

        $query = Order::with(['user', 'orderItems.product', 'timeSlot'])
            ->whereDate('created_at', '>=', $request->start_date)
            ->whereDate('created_at', '<=', $request->end_date);

        if ($request->status != 'all') {
            $query->where('status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        // Calculate totals
        $totalOrders = $orders->count();
        $totalRevenue = $orders->sum('total_amount');

        // Group orders by status
        $ordersByStatus = [
            'pending' => $orders->where('status', 'pending')->count(),
            'processing' => $orders->where('status', 'processing')->count(),
            'completed' => $orders->where('status', 'completed')->count(),
            'cancelled' => $orders->where('status', 'cancelled')->count(),
        ];

        // For PDF Download
        if ($request->has('download') && $request->download == 'pdf') {
            $pdf = PDF::loadView('admin.orders.report', compact(
                'orders',
                'start_date',
                'end_date',
                'status',
                'totalOrders',
                'totalRevenue',
                'ordersByStatus'
            ));

            return $pdf->download('orders-report-' . now()->format('Y-m-d') . '.pdf');
        }

        // Generate CSV file if requested
        if ($request->has('format') && $request->format == 'csv') {
            $filename = 'orders_report_' . Carbon::now()->format('Ymd_His') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function() use ($orders) {
                $file = fopen('php://output', 'w');

                // Add headers
                fputcsv($file, [
                    'Order ID', 'Customer Name', 'Email', 'Date', 'Time Slot',
                    'Items', 'Total Amount', 'Status', 'Payment Status', 'Payment Method'
                ]);

                // Add data
                foreach ($orders as $order) {
                    $items = '';
                    foreach ($order->orderItems as $item) {
                        $items .= $item->quantity . 'x ' . $item->product->name . ', ';
                    }
                    $items = rtrim($items, ', ');

                    $timeSlot = $order->timeSlot
                        ? $order->timeSlot->start_time . ' - ' . $order->timeSlot->end_time
                        : 'N/A';

                    fputcsv($file, [
                        '#' . $order->id,
                        $order->user->name ?? 'Guest',
                        $order->user->email ?? 'No email',
                        $order->created_at->format('Y-m-d H:i:s'),
                        $timeSlot,
                        $items,
                        $order->total_amount,
                        ucfirst($order->status),
                        $order->payment_status ? 'Paid' : 'Pending',
                        ucfirst($order->payment_method)
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        // For viewing in browser
        return view('admin.modules.orders_report', compact(
            'orders',
            'start_date',
            'end_date',
            'status',
            'totalOrders',
            'totalRevenue',
            'ordersByStatus'
        ));
    }
}
