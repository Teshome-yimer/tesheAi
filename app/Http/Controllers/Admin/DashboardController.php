<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_students'  => User::where('role', 'student')->count(),
            'total_courses'   => Course::count(),
            'total_orders'    => Order::where('status', 'paid')->count(),
            'revenue_etb'     => Order::where('status', 'paid')->where('currency', 'ETB')->sum('amount'),
            'revenue_usd'     => Order::where('status', 'paid')->where('currency', 'USD')->sum('amount'),
            'total_enrollments' => Enrollment::count(),
        ];

        $recentOrders = Order::with(['user', 'course'])->latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
