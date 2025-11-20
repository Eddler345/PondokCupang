<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Fish;
use App\Models\Order;

class AdminController extends Controller
{
    public function index()
    {
        // Ambil data dari database
        $totalOrders = Order::count();
        $totalFish = Fish::count();
        $totalUsers = User::count();

        // Ambil 5 pesanan terbaru
        $latestOrders = Order::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalFish',
            'totalUsers',
            'latestOrders'
        ));
    }

    public function users()
    {
        // Ambil semua user selain admin
        $users = User::where('role', '!=', 'admin')
                    ->withCount('orders')
                    ->latest()
                    ->get();

        return view('admin.users', compact('users'));
    }

    public function deleteUser(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Tidak dapat menghapus akun admin');
        }

        $user->delete();
        return back()->with('success', 'Pengguna berhasil dihapus');
    }
}
