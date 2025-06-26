<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\Ongkir;
use App\Models\Village;
use Illuminate\Http\Request;

class OngkirController extends Controller
{
    public function index()
    {
        $ongkirs = Ongkir::with(['city', 'district', 'village']);

        $search = request('search');
        if (request('search')) {
            $ongkirs->when($search, function ($query, $search) {
                $query->where('biaya', 'like', '%' . $search . '%')

                    // Relasi ke city
                    ->orWhereHas('city', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })

                    // Relasi ke district
                    ->orWhereHas('district', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })

                    // Relasi ke village
                    ->orWhereHas('village', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            })
                ->latest();
        }

        $ongkirs = $ongkirs->paginate(10)->appends(['search' => $search]);

        return view('master.ongkir.index', compact('ongkirs'));
    }

    public function create()
    {
        $cities = City::all();
        return view('master.ongkir.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'city_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required',
            'biaya' => 'required|numeric',
        ]);

        Ongkir::create($request->all());
        return redirect()->route('ongkir.index')->with('success', 'Data ongkir berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $ongkir = Ongkir::findOrFail($id);
        $cities = City::all();
        $districts = District::where('city_id', $ongkir->city_id)->get();
        $villages = Village::where('district_id', $ongkir->district_id)->get();

        return view('master.ongkir.edit', compact('ongkir', 'cities', 'districts', 'villages'));
    }

    public function update(Request $request, string $id)
    {
        $ongkir = Ongkir::findOrFail($id);

        $request->validate([
            'city_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required',
            'biaya' => 'required|numeric',
        ]);

        $ongkir->update($request->all());
        return redirect()->route('ongkir.index')->with('success', 'Data ongkir berhasil diubah.');
    }

    public function destroy(string $id)
    {
        $ongkir = Ongkir::findOrFail($id);

        $ongkir->delete();
        return redirect()->route('ongkir.index')->with('success', 'Data ongkir berhasil dihapus.');
    }

    // AJAX
    public function getDistricts($city_id)
    {
        return response()->json(District::where('city_id', $city_id)->get());
    }

    public function getVillages($district_id)
    {
        return response()->json(Village::where('district_id', $district_id)->get());
    }
}
