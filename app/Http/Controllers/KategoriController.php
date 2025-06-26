<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index()
    {
        $search = request('search');
        $kategoris = Kategori::latest();
        if (request('search')) {
            $kategoris->where('name', 'like', '%' . $search . '%')
                ->orWhere('slug', 'like', '%' . $search . '%');
        }

        $kategoris = $kategoris->paginate(10)->appends(['search' => $search]);

        return view('master.kategori.index', compact('kategoris', 'search'));
    }

    public function create()
    {
        return view('master.kategori.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'image_kategori' => 'nullable|image|file|mimes:png,jpg,jpeg,webp|max:1024',
        ]);

        $validatedData['slug'] = Str::slug($validatedData['name']);

        if ($request->file('image_kategori')) {
            $file = $request->file('image_kategori');
            $fileName = Str::slug($validatedData['name']) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('kategori-images', $fileName);
            $validatedData['image_kategori'] = 'kategori-images/' . $fileName;
        }

        Kategori::create($validatedData);

        return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(string $id)
    {
        $kategori = Kategori::findOrFail($id);

        return view('master.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, string $id)
    {;
        $kategori = Kategori::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required',
            'image_kategori' => 'nullable|image|file|mimes:png,jpg,jpeg,webp|max:1024',
        ]);

        $validatedData['slug'] = Str::slug($validatedData['name']);

        if ($request->file('image_kategori')) {
            if ($kategori->image_kategori != null && $kategori->image_kategori != 'kategori-images/default.jpg') {
                Storage::delete($kategori->image_kategori);
            }
            $file = $request->file('image_kategori');
            $fileName = Str::slug($validatedData['name']) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('kategori-images', $fileName);
            $validatedData['image_kategori'] = 'kategori-images/' . $fileName;
        }

        $kategori->update($validatedData);

        return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        if ($kategori->image_kategori) {
            if ($kategori->image_kategori != 'kategori-images/default.jpg') {
                Storage::delete($kategori->image_kategori);
            }
        }
        $kategori->delete();

        return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
