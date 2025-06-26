<?php

namespace App\Http\Controllers;

use App\Models\Rekening;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RekeningController extends Controller
{
    public function index()
    {
        $search = request('search');
        $banks = Rekening::latest();
        if (request('search')) {
            $banks->where('nama_bank', 'like', '%' . $search . '%')
                ->orWhere('rekening', 'like', '%' . $search . '%')
                ->orWhere('pemilik', 'like', '%' . $search . '%');
        }

        $banks = $banks->paginate(10)->appends(['search' => $search]);

        return view('master.bank.index', compact('banks', 'search'));
    }

    public function create()
    {
        return view('master.bank.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_bank' => 'required',
            'rekening' => 'required',
            'pemilik' => 'required',
            'logo_bank' => 'nullable|image|file|mimes:png,jpg,jpeg,webp|max:1024',
        ]);

        if ($request->file('logo_bank')) {
            $file = $request->file('logo_bank');
            $fileName = Str::slug($validatedData['nama_bank']) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('bank-images', $fileName);
            $validatedData['logo_bank'] = 'bank-images/' . $fileName;
        }

        Rekening::create($validatedData);

        return redirect()->route('rekening.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(string $id)
    {
        $bank = Rekening::findOrFail($id);

        return view('master.bank.edit', compact('bank'));
    }

    public function update(Request $request, string $id)
    {;
        $bank = Rekening::findOrFail($id);

        $validatedData = $request->validate([
            'nama_bank' => 'required',
            'rekening' => 'required',
            'pemilik' => 'required',
            'logo_bank' => 'nullable|image|file|mimes:png,jpg,jpeg,webp|max:1024',
        ]);

        if ($request->file('logo_bank')) {
            if ($bank->logo_bank != null) {
                Storage::delete($bank->logo_bank);
            }
            $file = $request->file('logo_bank');
            $fileName = Str::slug($validatedData['nama_bank']) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('bank-images', $fileName);
            $validatedData['logo_bank'] = 'bank-images/' . $fileName;
        }

        $bank->update($validatedData);

        return redirect()->route('rekening.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy(string $id)
    {
        $bank = Rekening::findOrFail($id);
        if ($bank->logo_bank) {
            Storage::delete($bank->logo_bank);
        }
        $bank->delete();

        return redirect()->route('rekening.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
