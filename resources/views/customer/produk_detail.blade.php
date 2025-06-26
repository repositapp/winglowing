@extends('layouts.first')
@section('title')
    Produk Detail
@endsection
@section('content')
    <!--product-details-area-start -->
    <div class="mt-product-details-area pt-60 fix">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 ">
                    <div class="mt-shop-details__wrapper mb-10">
                        <div class="row">
                            {{-- Thumbnail Gambar Produk --}}
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="mt-shop-details__tab-btn-box">
                                    <nav>
                                        <div class="nav nav-tab" id="nav-tab" role="tablist">
                                            @foreach ($produk->gambar as $key => $gbr)
                                                <button class="nav-links {{ $key == 0 ? 'active' : '' }}"
                                                    id="nav-tab-{{ $key }}" data-bs-toggle="tab"
                                                    data-bs-target="#tab-{{ $key }}" type="button" role="tab"
                                                    aria-controls="tab-{{ $key }}"
                                                    aria-selected="{{ $key == 0 ? 'true' : 'false' }}">
                                                    <img src="{{ asset('storage/' . $gbr->gambar) }}"
                                                        alt="Thumbnail {{ $key }}">
                                                </button>
                                            @endforeach
                                        </div>
                                    </nav>
                                </div>
                            </div>

                            {{-- Gambar Besar (Konten Tab) --}}
                            <div class="col-lg-9 col-md-9 col-sm-9">
                                <div class="mt-shop-details__tab-content-box mb-20">
                                    <div class="tab-content" id="nav-tabContent">
                                        @foreach ($produk->gambar as $key => $gbr)
                                            <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}"
                                                id="tab-{{ $key }}" role="tabpanel"
                                                aria-labelledby="nav-tab-{{ $key }}">
                                                <div class="mt-shop-details__tab-big-img">
                                                    <img src="{{ asset('storage/' . $gbr->gambar) }}"
                                                        alt="Gambar Produk {{ $key }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 ">
                    <div class="mt-shop-details__right-warp mb-10 p-relative">
                        @if ($produk->discount > 0)
                            <div class="mt-shop-details__offer mb-15">
                                <span class="red-color">-{{ $produk->discount }}% OFF</span>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success material-shadow" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <h3 class="mt-shop-details__title-sm mb-15">{{ $produk->nama_produk }}</h3>
                        <div class="mt-shop-details__price mb-17">
                            @if ($produk->discount > 0)
                                <del>Rp. {{ number_format($produk->price, 0, ',', '.') }}</del>
                                <span>Rp.
                                    {{ number_format($produk->price - ($produk->price * $produk->discount) / 100, 0, ',', '.') }}</span>
                            @else
                                <span>Rp. {{ number_format($produk->price, 0, ',', '.') }}</span>
                            @endif
                        </div>

                        <div class="mt-shop-details__product-info-2 mb-25">
                            <ul>
                                <li>Kategori:<span>{{ $produk->kategori->name }}</span></li>

                            </ul>
                        </div>
                        <form action="{{ route('keranjang.tambah') }}" method="POST">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            <div class="mt-shop-details__quantity-wrap mb-40 d-flex align-items-center">
                                <div class="mt-shop-details__quantity-box">
                                    <div class="mt-shop-details__quantity">
                                        <div class="mt-cart-minus mt-cart-min-plus"><i class="fal fa-minus"></i></div>
                                        <input type="text" name="qty" value="1">
                                        <div class="mt-cart-plus mt-cart-min-plus"><i class="fal fa-plus"></i></div>
                                    </div>
                                </div>
                                <div class="mt-shop-details__btn mr-12">
                                    @auth('user')
                                        <button type="submit" class="mt-btn"><i class="fa-solid fa-basket-shopping"></i><span
                                                class="ml-6">Tambahkan Ke Keranjang</span></button>
                                    @else
                                        <a class="mt-btn"
                                            href="{{ route('customer.login', ['redirect' => request()->url()]) }}"><i
                                                class="fa-solid fa-basket-shopping"></i><span class="ml-6">Login untuk
                                                Membeli</span></a>
                                    @endauth
                                </div>
                            </div>
                        </form>
                        <div class="mt-shop-details__product-box ">
                            <div class="mt-shop-details__product-box-item d-flex align-items-center ">
                                <div class="mt-shop-details__product-box-text">
                                    <h3 class="mt-content-tab-title mb-10">Deskripsi Produk</h3>
                                    <p>{{ $produk->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- product-details-area-end -->

    <!-- Start Popular Product Area -->
    <section class="mtpopular__product-area mtpopular__product-2 pt-0 pb-50 p-relative fix">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="mt-section-content mb-30">
                        <h3 class="mt-section-title">
                            Produk
                            <span>Lainnya</span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20"
                                    fill="none">
                                    <path
                                        d="M9 1.82196L10.429 6.82929L10.5619 7.29477L11.0314 7.17707L16.0824 5.91098L12.4604 9.65222L12.1237 10L12.4604 10.3478L16.0824 14.089L11.0314 12.8229L10.5619 12.7052L10.429 13.1707L9 18.178L7.57097 13.1707L7.43813 12.7052L6.9686 12.8229L1.91761 14.089L5.53957 10.3478L5.87627 10L5.53957 9.65222L1.91761 5.91098L6.9686 7.17707L7.43813 7.29477L7.57097 6.82929L9 1.82196Z"
                                        fill="#FDD057" stroke="#060121" />
                                </svg>
                            </span>
                        </h3>
                        <p>Temukan Produk Lain yang Anda Sukai <br> yang Berkaitan dengan Kategori
                            {{ $produk->kategori->name }}</p>
                    </div>
                </div>
                <div class="col-lg-6 ">
                    <div class="mtpopular__product-arrow text-end">
                        <div class="mtpopular__product-slider-left1">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14" viewBox="0 0 15 14"
                                    fill="none">
                                    <path
                                        d="M7.39367 0.820693C6.37396 5.14484 1.88 6.84235 1.46856 6.98943C1.4577 6.99331 1.45706 7.00855 1.4676 7.01347C1.87294 7.20245 6.37316 9.37583 7.39367 13.1793M14.54 7.00001L2.62943 7.00001"
                                        stroke="#060121" stroke-width="2" />
                                </svg>
                            </span>
                        </div>
                        <div class="mtpopular__product-slider-right1">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14" viewBox="0 0 15 14"
                                    fill="none">
                                    <path
                                        d="M7.60633 13.1793C8.62604 8.85516 13.12 7.15765 13.5314 7.01057C13.5423 7.00669 13.5429 6.99145 13.5324 6.98653C13.1271 6.79755 8.62684 4.62417 7.60633 0.820679M0.459961 6.99999L12.3706 6.99999"
                                        stroke="#060121" stroke-width="2" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mtpopular__product-wrap">
                <div class="swiper mtpopular_product_2_active">
                    <div class="swiper-wrapper">
                        @foreach ($produkKategori as $produk)
                            <div class="swiper-slide">
                                <div class="mthot__product-item-wrap ">
                                    <div class="mthot__product-item p-relative fix">
                                        <div class="mthot__product-img mb-10">
                                            @if ($produk->discount > 0)
                                                <div class="mtfeature__product-offer">
                                                    <span>{{ $produk->discount }}% OFF</span>
                                                </div>
                                            @endif
                                            <div class="mtfeature__product-img mb-15">
                                                <a href="{{ route('produk.detail', $produk->kode_produk) }}"><img
                                                        src="{{ asset('storage/' . $produk->gambarUtama->gambar) }}"
                                                        alt="Gambar Produk" width="90%"></a>
                                            </div>
                                        </div>
                                        <div class="mthot__product-content">
                                            <div
                                                class="mthot__product-ratcat mb-10 d-flex align-items-center justify-content-between">
                                                <div class="mthot__product-cate ">
                                                    <span>{{ $produk->kategori->name }}</span>
                                                </div>
                                            </div>
                                            <h6 class="mthot__product-title mb-30 ">
                                                <a
                                                    href="{{ route('produk.detail', $produk->kode_produk) }}">{{ $produk->nama_produk }}</a>
                                            </h6>
                                            <div
                                                class="mthot__product-price-wrap d-flex align-items-center justify-content-between">
                                                <div class="mthot__product-price">
                                                    @if ($produk->discount > 0)
                                                        <span>Rp.
                                                            {{ number_format($produk->price - ($produk->price * $produk->discount) / 100, 0, ',', '.') }}</span>
                                                        <del>Rp. {{ number_format($produk->price, 0, ',', '.') }}</del>
                                                    @else
                                                        <span>Rp. {{ number_format($produk->price, 0, ',', '.') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Popular Product Area -->
@endsection
