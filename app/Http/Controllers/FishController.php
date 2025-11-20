<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BettaFish;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class FishController extends Controller
{
    public function index()
    {
        $fish = BettaFish::all();
        return view('admin.fish-index', compact('fish'));
    }

    public function create()
    {
        return view('admin.fish-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name','type','price','stock','description']);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/fish', 'public');
            $data['image'] = $path;
        }

        BettaFish::create($data);
        return redirect()->route('admin.fish.index')->with('success', 'Data ikan berhasil ditambahkan!');
    }

    public function edit(BettaFish $fish)
    {
        return view('admin.fish-edit', compact('fish'));
    }

    public function update(Request $request, BettaFish $fish)
    {
        \Log::info('Update fish request:', $request->all());
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name','type','price','stock','description']);
        if ($request->hasFile('image')) {
            // delete old image if exists
            if ($fish->image) {
                Storage::disk('public')->delete($fish->image);
            }
            $file = $request->file('image');
            $resizedPath = $this->storeResizedImage($file);
            $data['image'] = $resizedPath;
        }

        try {
            $fish->update($data);
            \Log::info('Fish updated successfully:', $data);
            return redirect()->route('admin.fish.index')->with('success', 'Data ikan berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error('Error updating fish:', ['error' => $e->getMessage(), 'data' => $data]);
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data ikan: ' . $e->getMessage());
        }
    }

    public function deleteImage(BettaFish $fish)
    {
        if ($fish->image) {
            Storage::disk('public')->delete($fish->image);
            $fish->image = null;
            $fish->save();
        }
        return back()->with('success', 'Gambar berhasil dihapus');
    }

    /**
     * Resize and store uploaded image using Intervention Image if available, otherwise move original
     */
    protected function storeResizedImage($file)
    {
        try {
            if (class_exists(\Intervention\Image\ImageManagerStatic::class)) {
                $img = \Intervention\Image\ImageManagerStatic::make($file->getRealPath());
                $img->orientate();
                $img->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $filename = 'uploads/fish/' . uniqid() . '.' . $file->getClientOriginalExtension();
                Storage::disk('public')->put($filename, (string) $img->encode());
                return $filename;
            }
        } catch (\Exception $e) {
            // fallback below
        }

        // fallback: store original file
        return $file->store('uploads/fish', 'public');
    }

    public function destroy(BettaFish $fish)
    {
        if ($fish->image) {
            Storage::disk('public')->delete($fish->image);
        }
        $fish->delete();
        return redirect()->route('admin.fish.index')->with('success', 'Data ikan berhasil dihapus!');
    }
}
