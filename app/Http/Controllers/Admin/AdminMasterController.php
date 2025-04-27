<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class AdminMasterController extends Controller
{
    public function get_dashboard()
    {
        // Get today's orders
        $todayOrders = Order::whereDate('created_at', today())->count();

        // Get total sales (count of all orders)
        $totalSales = Order::count();

        // Get total users
        $totalUsers = User::count();

        return view('admin.modules.dashboard', compact('todayOrders', 'totalSales', 'totalUsers'));
    }
}
