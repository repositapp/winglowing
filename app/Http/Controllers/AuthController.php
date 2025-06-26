<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function index(): View
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|min:5',
            'password' => 'required|min:8'
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            if (Auth::guard('web')->user()->role !== 'admin') {
                Auth::guard('web')->logout();
                return back()->withErrors(['username' => 'Akun ini bukan admin.']);
            }

            $request->session()->regenerate();
            return redirect('admin/dashboard');
        }

        return back()->with('loginError', 'Gagal! Kombinasi username dan kata sandi tidak sesuai. Silahkan coba lagi.');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
