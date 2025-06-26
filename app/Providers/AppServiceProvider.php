<?php

namespace App\Providers;

use App\Models\Aplikasi;
use App\Models\Keranjang;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        $aplikasi = Aplikasi::first();
        View::share('aplikasi', $aplikasi);

        View::composer('layouts.dist-topbar', function ($view) {
            if (auth('user')->check()) {
                $userId = auth('user')->id();

                $cartItems = Keranjang::where('user_id', $userId)->get();
                $cartCount = $cartItems->count(); // jumlah jenis produk
                $cartTotal = $cartItems->sum(function ($item) {
                    return $item->qty * $item->produk->price;
                });

                $view->with([
                    'cartCount' => $cartCount,
                    'cartTotal' => $cartTotal,
                ]);
            } else {
                $view->with([
                    'cartCount' => 0,
                    'cartTotal' => 0,
                ]);
            }
        });
    }
}
