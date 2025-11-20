<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class AdminPageController extends Controller
{
    public function editHome()
    {
        $page = Page::firstWhere('key', 'home');
        return view('admin.pages.edit-home', compact('page'));
    }

    public function updateHome(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
        ]);

        $page = Page::firstOrCreate(['key' => 'home']);
        $page->update($request->only('title', 'content'));

        return redirect()->route('admin.dashboard')->with('success', 'Beranda berhasil diperbarui');
    }
}
