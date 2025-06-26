<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Biodata;
use App\Models\User;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class CustomerAuthController extends Controller
{
    public function index(Request $request): View
    {
        $redirect = $request->query('redirect', route('index'));
        return view('customer.login', compact('redirect'));
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|min:5',
            'password' => 'required|min:8'
        ]);


        if (Auth::guard('user')->attempt($credentials)) {
            if (Auth::guard('user')->user()->role !== 'user') {
                Auth::guard('user')->logout();
                return back()->with('error', 'Akun ini bukan user.');
            }

            $request->session()->regenerate();
            // Ambil URL tujuan dari request
            $redirect = $request->input('redirect', route('index'));
            return redirect()->intended($redirect);
        }

        return back()->with('error', 'Gagal! Kombinasi username dan kata sandi tidak sesuai. Silahkan coba lagi.');
    }

    public function logout()
    {
        Auth::guard('user')->logout();

        return redirect()->route('customer.login');
    }

    public function register(Request $request): View
    {
        $villages = Village::all();
        $redirect = $request->query('redirect', route('index'));
        return view('customer.register', compact('redirect', 'villages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|min:5|max:255|unique:users',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:8',
            'telepon'    => 'required|max:20',
            'village_id' => 'required|exists:villages,id',
            'alamat'     => 'nullable|string',
            'kode_pos'   => 'nullable|string|max:10',
        ]);

        $unique = User::where('username', $request->username)->exists();

        if (!empty($unique)) {
            // Ambil URL redirect jika ada
            $redirect = $request->input('redirect', route('index'));
            // Redirect ke halaman registrasi dan bawa redirect URL
            return redirect()->route('customer.register', ['redirect' => $redirect])
                ->with(['error' => 'Data Sudah Ada!']);
        } else {
            $user = User::create([
                'name'              => $request->name,
                'username'          => $request->username,
                'email'             => $request->email,
                'password'          => Hash::make($request->password),
                'email_verified_at' => 'users-images/1J7iwiUja9gMqtHL7eIzR6RbaH0rrzZ5buklDQLy.png',
                'email_verified_at' => now(),
                'role'              => 'user',
                'status'            => true,
            ]);

            // Ambil relasi kelurahan → kecamatan → kota
            $village = Village::with('district.city')->findOrFail($request->village_id);
            $district = $village->district;
            $city = $district->city;

            // Simpan biodata
            Biodata::create([
                'user_id'     => $user->id,
                'nama_lengkap' => $user->name,
                'telepon'     => $request->telepon,
                'village_id'  => $village->id,
                'district_id' => $district->id,
                'city_id'     => $city->id,
                'alamat'      => $request->alamat,
                'kode_pos'    => $request->kode_pos,
            ]);

            // Ambil URL redirect jika ada
            $redirect = $request->input('redirect', route('index'));
            // Redirect ke halaman login dan bawa redirect URL
            return redirect()->route('customer.login', ['redirect' => $redirect])
                ->with(['success' => 'Data Berhasil Disimpan!']);
        }
    }
}
