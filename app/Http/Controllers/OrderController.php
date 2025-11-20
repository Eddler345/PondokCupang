<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\BettaFish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function userOrders()
    {
        $orders = Order::where('user_id', Auth::id())
                      ->with(['bettaFish', 'user'])
                      ->latest()
                      ->get();
        return view('user.orders.index', compact('orders'));
    }
    public function index()
    {
        $orders = Auth::user()->role === 'admin'
            ? Order::with(['user', 'bettaFish'])->get()
            : Order::where('user_id', Auth::id())->with('bettaFish')->get();

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Admin tidak dapat membuat pesanan');
        }

        $fishes = BettaFish::where('stock', '>', 0)->get();
        return view('user.orders.create', compact('fishes'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Admin tidak dapat membuat pesanan');
        }

        $request->validate([
            'betta_fish_id' => 'required|exists:betta_fish,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $fish = BettaFish::findOrFail($request->betta_fish_id);
        
        // Validasi stok
        if ($request->quantity > $fish->stock) {
            return back()->withErrors(['quantity' => 'Jumlah pesanan melebihi stok yang tersedia'])
                        ->withInput();
        }

        $totalPrice = $fish->price * $request->quantity;

        // Kurangi stok
        $fish->decrement('stock', $request->quantity);

        $order = Order::create([
            'user_id' => Auth::id(),
            'betta_fish_id' => $fish->id,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        return redirect()->route('user.dashboard')
            ->with('success', 'Pesanan berhasil dibuat! Silakan tunggu konfirmasi dari admin.');
    }

    public function edit(Order $order)
    {
        $fish = BettaFish::all();
        return view('orders.edit', compact('order', 'fish'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'betta_fish_id' => 'required|exists:betta_fish,id',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|string',
        ]);

        $fish = BettaFish::findOrFail($request->betta_fish_id);
        $totalPrice = $fish->price * $request->quantity;

        $order->update([
            'betta_fish_id' => $fish->id,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil diperbarui!');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dihapus!');
    }
}
