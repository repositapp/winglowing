<header class="mtheader__area p-relative">
    <!-- header top area start -->
    <div class="mtheader__top-area mtheader__top-2 theme-bg p-relative d-none d-lg-block">
        <div class="container">
            <div class="mtborder__top-wrapper d-flex align-items-center justify-content-between">
                <div class="mtheader__top-left">
                    <a href="#"><i class="fa-light fa-envelope"></i><span><span> {{ $aplikasi->email }}
                            </span></span></a>
                    <span>
                        <i class="fa-solid fa-star-sharp"></i>
                    </span>
                    <a href="#"><i class="fa-light fa-location-dot"></i><span>{{ $aplikasi->alamat }}</span></a>
                </div>
                <div class="mtheader__top-right d-flex align-items-center justify-content-between">
                    <div class="mtheader__top-social">
                        <a href="#"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- header Menu area start -->
    <div id="mt-header-sticky" class="mtheader__bottom-area mtheader__bottom-2 mt-sticky-theme-2 p-relative header-bg">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-2 col-6">
                    <div class="mtheader__bottom-category-wrap p-relative">
                        <div class="mtheader__bottom-category">
                            <div class="mtheader__logo">
                                <a href="{{ route('index') }}"><img src="{{ asset('storage/' . $aplikasi->logo) }}"
                                        alt="Arumi Galeri" width="35%"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-10 col-6">
                    <div
                        class="mtheader__bottom-wrapper p-relative d-flex align-items-center justify-content-end justify-content-xl-between">
                        <div class="mtheader__bottom-menu d-none d-xl-block">
                            <nav class="mt-mobile-menu-active">
                                <ul>
                                    <li><a href="{{ route('index') }}">Beranda</a></li>
                                    <li><a href="{{ route('produk.kategori', 1) }}">Kategori</a></li>
                                    <li><a href="{{ route('produk.all') }}">Produk</a></li>
                                    <li><a href="{{ route('produk.diskon') }}">Diskon</a></li>
                                    <li><a href="{{ route('produk.populer') }}">Populer</a></li>
                                    @auth
                                        <li><a href="{{ route('transaksi.list') }}">Transaksi</a></li>
                                    @endauth
                                </ul>
                            </nav>
                        </div>
                        <div
                            class="mtheader__midel-account-wrap p-relative d-flex align-items-center justify-content-between">
                            @guest('user')
                                <div class="mtheader__midel-login mtheader__mobile-cart">
                                    <a href="{{ route('customer.login', ['redirect' => request()->fullUrl()]) }}"
                                        class="mt__header-login-another-page">
                                        <i class="fa-solid fa-user-plus"></i>
                                        <span>Login your</span>
                                        <h6>Account</h6>
                                    </a>
                                </div>
                            @else
                                <div class="mtheader__midel-login mtheader__mobile-cart">
                                    <a href="{{ route('customer.logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fa-solid fa-user" style="margin-right: 30px;"></i>
                                        <span>Logout</span>
                                        <h6 style="font-size: 10px; line-height: 1.8;">{{ auth('user')->user()->name }}
                                        </h6>
                                    </a>
                                    <form id="logout-form" action="{{ route('customer.logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </div>

                                <span>
                                    <i class="fa-solid fa-star-sharp"></i>
                                </span>

                                <div class="mtheader__midel-login mtheader__mobile-cart">
                                    <div class="mtheader__midel-card-value">
                                        <a href="{{ route('keranjang.index') }}">
                                            <i class="fa-solid fa-basket-shopping"></i>
                                            <p>{{ $cartCount }}</p>
                                            <span>Cart Items</span>
                                            <h6 style="font-size: 10px; line-height: 1.8;">
                                                Rp{{ number_format($cartTotal, 0, ',', '.') }}</h6>
                                        </a>
                                    </div>
                                </div>
                            @endguest
                        </div>
                        <div class="mt-header-toogle  d-xl-none text-end">
                            <button class="mt-offcanvas-toogle mt-offcanvas-toogle-2"><i
                                    class="fa-regular fa-bars-staggered"></i></button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</header>
