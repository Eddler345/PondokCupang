<?php

namespace App\Http\Controllers;

use App\Models\BettaFish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BettaFishController extends Controller
{
    public function index()
    {
        $fish = BettaFish::all();
        return view('bettafish.index', compact('fish'));
    }

    public function create()
    {
        return view('bettafish.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('fish-images', 'public');
            $data['image'] = $path;
        }

        BettaFish::create($data);
        return redirect()->route('admin.fish.index')->with('success', 'Data ikan berhasil ditambahkan');
    }

    public function edit(BettaFish $bettafish)
    {
        return view('bettafish.edit', compact('bettafish'));
    }

    public function update(Request $request, BettaFish $bettafish)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($bettafish->image && Storage::disk('public')->exists($bettafish->image)) {
                Storage::disk('public')->delete($bettafish->image);
            }
            
            $file = $request->file('image');
            $path = $file->store('fish-images', 'public');
            $data['image'] = $path;
        }

        $bettafish->update($data);
        return redirect()->route('admin.fish.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(BettaFish $bettafish)
    {
        // Hapus gambar jika ada
        if ($bettafish->image && Storage::disk('public')->exists($bettafish->image)) {
            Storage::disk('public')->delete($bettafish->image);
        }
        
        $bettafish->delete();
        return redirect()->route('admin.fish.index')->with('success', 'Data berhasil dihapus');
    }

    public function deleteImage(BettaFish $fish)
    {
        if ($fish->image && Storage::disk('public')->exists($fish->image)) {
            Storage::disk('public')->delete($fish->image);
        }
        
        $fish->update(['image' => null]);
        return redirect()->back()->with('success', 'Gambar berhasil dihapus');
    }
}
