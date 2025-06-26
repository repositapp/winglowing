@extends('layouts.first')
@section('title')
    Beranda
@endsection
@section('content')
    <!-- Start  Categories -->
    <section class="mtshop__category-area pt-40 pb-55 p-relative fix">
        <div class="container">
            <div class="mtshop__category-2 p-relative">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <div class="mtshop__category-wrapper">
                            <div class="swiper mtshop__category_2_active">
                                <div class="swiper-wrapper">
                                    @foreach ($kategoris as $kategori)
                                        <div class="swiper-slide">
                                            <div class="mtshop__category-item ">
                                                <a href="{{ route('produk.kategori', $kategori->id) }}">
                                                    <img src="{{ asset('storage/' . $kategori->image_kategori) }}"
                                                        alt="Gambar Kategori" width="50%">
                                                    <h5 class="mtshop__category-title">{{ $kategori->name }}</h5>
                                                    <span>{{ $kategori->produk_count }} ITEMS</span>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="mtshop__category-arrow mtshop__category-arrow-2  mb-30 d-flex justify-content-end p-relative">
                        <div class="mtshop__category-arrow-left mtshop__category-arrow">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14" viewBox="0 0 15 14"
                                    fill="none">
                                    <path
                                        d="M7.39367 0.820693C6.37396 5.14484 1.88 6.84235 1.46856 6.98943C1.4577 6.99331 1.45706 7.00855 1.4676 7.01347C1.87294 7.20245 6.37316 9.37583 7.39367 13.1793M14.54 7.00001L2.62943 7.00001"
                                        stroke="#060121" stroke-width="2" />
                                </svg>
                            </span>
                        </div>
                        <div class="mtshop__category-arrow-right mtshop__category-arrow">
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
        </div>
    </section>
    <!-- End Categories -->

    <!-- Start Feature Product Area -->
    <section class="mtfeature__product-area mtfeature__product-2 pt-40 pb-75 p-relative fix"
        data-background="{{ URL::asset('dist/img/bg/feature-bg-2-1.png') }}">
        <div class="container">
            <div class="mt-section-content text-center mb-50">
                <h3 class="mt-section-title">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20"
                            fill="none">
                            <path
                                d="M9 1.82196L10.429 6.82929L10.5619 7.29477L11.0314 7.17707L16.0824 5.91098L12.4604 9.65222L12.1237 10L12.4604 10.3478L16.0824 14.089L11.0314 12.8229L10.5619 12.7052L10.429 13.1707L9 18.178L7.57097 13.1707L7.43813 12.7052L6.9686 12.8229L1.91761 14.089L5.53957 10.3478L5.87627 10L5.53957 9.65222L1.91761 5.91098L6.9686 7.17707L7.43813 7.29477L7.57097 6.82929L9 1.82196Z"
                                fill="#FDD057" stroke="#060121" />
                        </svg>
                    </span>
                    Produk
                    <span>Keseluruhan</span>
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20"
                            fill="none">
                            <path
                                d="M9 1.82196L10.429 6.82929L10.5619 7.29477L11.0314 7.17707L16.0824 5.91098L12.4604 9.65222L12.1237 10L12.4604 10.3478L16.0824 14.089L11.0314 12.8229L10.5619 12.7052L10.429 13.1707L9 18.178L7.57097 13.1707L7.43813 12.7052L6.9686 12.8229L1.91761 14.089L5.53957 10.3478L5.87627 10L5.53957 9.65222L1.91761 5.91098L6.9686 7.17707L7.43813 7.29477L7.57097 6.82929L9 1.82196Z"
                                fill="#FDD057" stroke="#060121" />
                        </svg>
                    </span>
                </h3>
                <p>Temukan Pilihan Barang yang Anda Sukai. <br> Anda dapat Melakukan Pembelian dengan Mengklik Salah Satu
                    Produk</p>
            </div>
            <div class="mtfeature__product-wrapper">
                <div class="mtfeature__product-cols">
                    @foreach ($produkAcak as $produk)
                        <div class="mtfeature__product-item p-relative fix">
                            @if ($produk->discount > 0)
                                <div class="mtfeature__product-offer">
                                    <span>{{ $produk->discount }}% OFF</span>
                                </div>
                            @endif
                            <div class="mtfeature__product-img mb-15">
                                <a href="{{ route('produk.detail', $produk->kode_produk) }}">
                                    <img src="{{ asset('storage/' . $produk->gambarUtama->gambar) }}" alt="Gambar Produk"
                                        width="90%">
                                </a>

                            </div>
                            <div class="mtfeature__product-content mb-15">
                                <div class="mtfeature__product-cate mb-10">
                                    <span>{{ $produk->kategori->name }}</span>
                                </div>
                                <h5 class="mtfeature__product-title">
                                    <a
                                        href="{{ route('produk.detail', $produk->kode_produk) }}">{{ $produk->nama_produk }}</a>
                                </h5>
                            </div>
                            <div
                                class="mtfeature__product-pricing-wrap pt-10 d-flex align-items-center justify-content-between">
                                <div class="mtfeature__product-price">
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
                    @endforeach
                </div>
            </div>
        </div>
        <div class="text-center pt-50">
            <div class="mtpopular__product-btn">
                <a href="{{ route('produk.all') }}" class="mt-btn">
                    <span>Lihat Semua</span> <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
    </section>
    <!-- End Feature Product Area -->

    <!-- Start Popular Product Area -->
    <section class="mtpopular__product-area mtpopular__product-2 pt-75 pb-70 p-relative fix"
        data-background="{{ URL::asset('dist/img/bg/blog-bg-2-1.jpg') }}">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 ">
                    <div class="mt-section-content mb-30">
                        <h3 class="mt-section-title">
                            Produk
                            <span>Diskon</span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20"
                                    fill="none">
                                    <path
                                        d="M9 1.82196L10.429 6.82929L10.5619 7.29477L11.0314 7.17707L16.0824 5.91098L12.4604 9.65222L12.1237 10L12.4604 10.3478L16.0824 14.089L11.0314 12.8229L10.5619 12.7052L10.429 13.1707L9 18.178L7.57097 13.1707L7.43813 12.7052L6.9686 12.8229L1.91761 14.089L5.53957 10.3478L5.87627 10L5.53957 9.65222L1.91761 5.91098L6.9686 7.17707L7.43813 7.29477L7.57097 6.82929L9 1.82196Z"
                                        fill="#FDD057" stroke="#060121" />
                                </svg>
                            </span>
                        </h3>
                        <p>Produk Diskon yang ada di Toko Kami! Segera Lakukan Pembelian untuk <br> Mendapatkan Diskon
                            Produk Kami.</p>
                    </div>
                </div>
            </div>
            <div class="mtpopular__product-main-wrap p-relative d-flex">
                <div class="mtpopular__product-banner p-relative wow img-custom-anim-left" data-wow-duration="1.5s"
                    data-wow-delay="0.1s" data-background="{{ URL::asset('dist/img/banner/hp-banner-1-1.jpg') }}">
                    <div class="mtpopular__product-text wow img-custom-anim-left" data-wow-duration="1.5s"
                        data-wow-delay="0.5s">
                        <h3 class="mtpopular__product-bannertitle">Ayo Cepat</h3>
                        <h5 class="mtpopular__product-bannersubtitle"><span>Dapatkan Diskon</span> <br> Hari Ini</h5>
                    </div>
                </div>
                <div class="mtpopular__product-wrap-tab ">
                    <div class="tab-content" id="pills-tabContent_tsdy">
                        <div class="tab-pane show active" id="mttop-cat1" role="tabpanel"
                            aria-labelledby="mttop-main-cat1">
                            <div class="mtpopular__product-inner">
                                <div class="mtpopular__product-wrap">
                                    <div class="swiper mtpopular_product_2_active">
                                        <div class="swiper-wrapper">
                                            @foreach ($produkDiskon as $produk)
                                                <div class="swiper-slide">
                                                    <div class="mthot__product-item-wrap ">
                                                        <div class="mthot__product-item p-relative fix">
                                                            <div class="mthot__product-img mb-10">
                                                                @if ($produk->discount > 0)
                                                                    <div class="mtfeature__product-offer">
                                                                        <span>{{ $produk->discount }}% OFF</span>
                                                                    </div>
                                                                @endif
                                                                <a
                                                                    href="{{ route('produk.detail', $produk->kode_produk) }}"><img
                                                                        src="{{ asset('storage/' . $produk->gambarUtama->gambar) }}"
                                                                        alt="Gambar Produk" width="70%"></a>
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
                                                                        href="{{ route('produk.detail', $produk->kode_produk) }}">{{ $produk->nama_produk }}
                                                                    </a>
                                                                </h6>
                                                                <div
                                                                    class="mthot__product-price-wrap d-flex align-items-center justify-content-between">
                                                                    <div class="mthot__product-price">
                                                                        @if ($produk->discount > 0)
                                                                            <span>Rp.
                                                                                {{ number_format($produk->price - ($produk->price * $produk->discount) / 100, 0, ',', '.') }}</span>
                                                                            <del>Rp.
                                                                                {{ number_format($produk->price, 0, ',', '.') }}</del>
                                                                        @else
                                                                            <span>Rp.
                                                                                {{ number_format($produk->price, 0, ',', '.') }}</span>
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
                        </div>
                    </div>
                </div>
            </div>
            <div class="mtpopular__product-arrowbtn">
                <div class="row">
                    <div class="col-lg-6 col-md-7 col-sm-6">
                        <div class="mtpopular__product-arrow">
                            <div class="mtpopular__product-slider-left1">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14"
                                        viewBox="0 0 15 14" fill="none">
                                        <path
                                            d="M7.39367 0.820693C6.37396 5.14484 1.88 6.84235 1.46856 6.98943C1.4577 6.99331 1.45706 7.00855 1.4676 7.01347C1.87294 7.20245 6.37316 9.37583 7.39367 13.1793M14.54 7.00001L2.62943 7.00001"
                                            stroke="#060121" stroke-width="2" />
                                    </svg>
                                </span>
                            </div>
                            <div class="mtpopular__product-slider-right1">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14"
                                        viewBox="0 0 15 14" fill="none">
                                        <path
                                            d="M7.60633 13.1793C8.62604 8.85516 13.12 7.15765 13.5314 7.01057C13.5423 7.00669 13.5429 6.99145 13.5324 6.98653C13.1271 6.79755 8.62684 4.62417 7.60633 0.820679M0.459961 6.99999L12.3706 6.99999"
                                            stroke="#060121" stroke-width="2" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-5 col-sm-6">
                        <div class="mtpopular__product-btn">
                            <a href="{{ route('produk.diskon') }}" class="mt-btn">
                                <span>Lihat Semua</span> <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- End Popular Product Area -->

    <!-- Start Feature Product Area -->
    <section class="mtfeature__product-area mtfeature__product-2 pt-90 pb-130 p-relative fix"
        data-background="{{ URL::asset('dist/img/bg/feature-bg-2-1.png') }}">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="mt-section-content mb-50">
                        <h3 class="mt-section-title">
                            Produk
                            <span>Populer</span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20"
                                    viewBox="0 0 18 20" fill="none">
                                    <path
                                        d="M9 1.82196L10.429 6.82929L10.5619 7.29477L11.0314 7.17707L16.0824 5.91098L12.4604 9.65222L12.1237 10L12.4604 10.3478L16.0824 14.089L11.0314 12.8229L10.5619 12.7052L10.429 13.1707L9 18.178L7.57097 13.1707L7.43813 12.7052L6.9686 12.8229L1.91761 14.089L5.53957 10.3478L5.87627 10L5.53957 9.65222L1.91761 5.91098L6.9686 7.17707L7.43813 7.29477L7.57097 6.82929L9 1.82196Z"
                                        fill="#FDD057" stroke="#060121" />
                                </svg>
                            </span>
                        </h3>
                        <p>Produk Terlaris yang ada di Toko Kami! Temukan Produk Favorit Pelanggan Lain <br> yang Sering di
                            Beli.</p>
                    </div>
                </div>
            </div>
            <div class="mtfeature__product-wrapper">
                <div class="mtfeature__product-cols">
                    @foreach ($produkPopuler as $produk)
                        <div class="mtfeature__product-item p-relative fix">
                            @if ($produk->discount > 0)
                                <div class="mtfeature__product-offer">
                                    <span>{{ $produk->discount }}% OFF</span>
                                </div>
                            @endif
                            <div class="mtfeature__product-img mb-15">
                                <a href="{{ route('produk.detail', $produk->kode_produk) }}">
                                    <img src="{{ asset('storage/' . $produk->gambarUtama->gambar) }}" alt="Gambar Produk"
                                        width="90%">
                                </a>

                            </div>
                            <div class="mtfeature__product-content mb-15">
                                <div class="mtfeature__product-cate mb-10">
                                    <span>{{ $produk->kategori->name }}</span>
                                </div>
                                <h5 class="mtfeature__product-title">
                                    <a
                                        href="{{ route('produk.detail', $produk->kode_produk) }}">{{ $produk->nama_produk }}</a>
                                </h5>
                            </div>
                            <div
                                class="mtfeature__product-pricing-wrap pt-10 d-flex align-items-center justify-content-between">
                                <div class="mtfeature__product-price">
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
                    @endforeach
                </div>
            </div>
        </div>
        <div class="text-center pt-50">
            <div class="mtpopular__product-btn">
                <a href="{{ route('produk.populer') }}" class="mt-btn">
                    <span>Lihat Semua</span> <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
    </section>
    <!-- End Feature Product Area -->
@endsection
