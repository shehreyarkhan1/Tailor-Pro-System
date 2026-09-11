<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use Illuninate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomers = Customer::count();
        $activeOrders = Order::whereNotIn('status', ['delivered', 'cancelled'])->count();
        $readyForDelivery = Order::where('status', 'ready')->count();
        $overdueOrders = Order::whereNotIn('status', ['delivered', 'cancelled'])->where('delivery_date', '<', now())->count();
        $monthlyRevenue = Invoice::whereMonth('issue_date', now()->month)->whereYear('issue_date', now()->year)->sum('paid_amount');
        $pendingPayments = Invoice::where('status', '!=', 'paid')->sum(DB::raw('amount - paid_amount'));
        $recentOrders = Order::with('customer')->latest()->take(8)->get();
        $statusCounts = Order::select('status', DB::raw('count(*) as total'))->groupBy('status')->pluck('total', 'status');
        $last7DaysRevenue = Invoice::select(DB::raw('DATE(issue_date) as day'), DB::raw('SUM(paid_amount) as total'))
        ->where('issue_date', '>=', now()->subDays(7))->groupBy('day')->orderBy('day')->get();

        return view('dashboard.index',compact('totalCustomers','activeOrders','readyForDelivery',
        'overdueOrders','monthlyRevenue','pendingPayments','recentOrders','statusCounts','last7DaysRevenue'));
    }
}
