<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\BettaFish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            return $this->adminDashboard();
        }
        
        return $this->userDashboard();
    }

    private function adminDashboard()
    {
        $totalOrders = Order::count();
        $totalFish = BettaFish::count();
        $totalUsers = User::count();

        // Ambil pesanan terbaru (pakai relasi bettaFish)
        $latestOrders = Order::with(['user', 'bettaFish'])->latest()->take(5)->get();

         $statusCount = [
        'pending' => Order::where('status', 'pending')->count(),
        'diproses' => Order::where('status', 'diproses')->count(),
        'selesai' => Order::where('status', 'selesai')->count(),
        'dibatalkan' => Order::where('status', 'dibatalkan')->count(),
    ];

        // Data untuk Chart: Pesanan per tanggal
        $ordersByDate = Order::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $orderDates = $ordersByDate->pluck('date');
        $orderCounts = $ordersByDate->pluck('count');

        // Data untuk Chart: Stok ikan
        $fishNames = BettaFish::pluck('name');
        $fishStock = BettaFish::pluck('stock');

        return view('admin.dashboard', compact(
            'totalOrders', 'totalFish', 'totalUsers',
            'statusCount',
            'latestOrders', 'orderDates', 'orderCounts',
            'fishNames', 'fishStock'
        ));
    }

    private function userDashboard()
    {
        // Get user's own orders
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
                      ->with('bettaFish')
                      ->latest()
                      ->get();

        $orderCount = $orders->count();
        
        $statusCount = [
            'pending' => $orders->where('status', 'pending')->count(),
            'diproses' => $orders->where('status', 'diproses')->count(),
            'selesai' => $orders->where('status', 'selesai')->count(),
            'dibatalkan' => $orders->where('status', 'dibatalkan')->count(),
        ];

        return view('user.dashboard', compact('orders', 'orderCount', 'statusCount'));
    }
}
