@extends('layouts.first')
@section('title')
    Produk
@endsection
@section('content')
    <!-- Start Shop Area -->
    <section class="mtshop__area pt-60 pb-120 p-relative">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4">
                    <div class="mt-shop-sidebar mr-10">
                        <!-- categories -->
                        <div class="mt-shop-widget mb-50">
                            <h3 class="mt-shop-widget-title mb-20">Kategori Produk</h3>
                            <div class="mt-shop-widget-content">
                                <div class="mt-shop-widget-categories">
                                    <ul>
                                        @foreach ($kategoris as $kategori)
                                            <li><a href="{{ route('produk.kategori', $kategori->id) }}"><img
                                                        src="{{ asset('storage/' . $kategori->image_kategori) }}"
                                                        alt="Gambar Kategori" width="8%">{{ $kategori->name }}
                                                    <span><i class="fa-light fa-angle-right"></i></span></a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="mt-shop-wrapper">
                        <!-- Showing -->
                        <div class="mtheader__midel-search p-relative mb-30">
                            <form action="{{ url()->current() }}" method="GET">
                                <input type="text" name="search" placeholder="Cari produk yang anda sukai..."
                                    class="mt__border-effect">
                                <button type="submit">
                                    <i class="fa-regular fa-magnifying-glass"></i><span>SEARCH</span>
                                </button>
                            </form>
                        </div>

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab">
                                <div class="mt-shop-grid-wrapper ">
                                    <div class="row">
                                        @forelse($produks as $produk)
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                                                <div class="mt-shop-grid-item p-relative mb-40">
                                                    <div class="mt-shop-grid-img mb-10">
                                                        <a href="{{ route('produk.detail', $produk->kode_produk) }}"><img
                                                                src="{{ asset('storage/' . $produk->gambarUtama->gambar) }}"
                                                                alt="Gambar Produk" width="70%"></a>
                                                    </div>
                                                    <div class="mt-shop-grid-content">
                                                        <div
                                                            class="mtflash__product-content mb-15 d-flex align-items-center justify-content-between">
                                                            <div class="mtfeature__product-price">
                                                                @if ($produk->discount > 0)
                                                                    <span>Rp.
                                                                        {{ number_format($produk->price - ($produk->price * $produk->discount) / 100, 0, ',', '.') }}</span>
                                                                    <br>
                                                                    <del>Rp.
                                                                        {{ number_format($produk->price, 0, ',', '.') }}</del>
                                                                @else
                                                                    <span>Rp.
                                                                        {{ number_format($produk->price, 0, ',', '.') }}</span>
                                                                @endif
                                                            </div>
                                                            @if ($produk->discount > 0)
                                                                <div class="mtflash__product-ratting">
                                                                    <span
                                                                        class="mtflash__product-review-number">{{ $produk->discount }}%
                                                                        OFF</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="mtfeature__product-content text-start mb-15">
                                                            <h5 class="mtfeature__product-title">
                                                                <a
                                                                    href="{{ route('produk.detail', $produk->kode_produk) }}">
                                                                    {{ $produk->nama_produk }}</a>
                                                            </h5>
                                                        </div>
                                                        <div
                                                            class="mtfeature__product-pricing-wrap d-flex align-items-center justify-content-between">
                                                            <div class="mtfeature__product-cate">
                                                                <span>{{ $produk->kategori->name }}</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                                                <p class="text-center">Produk tidak ditemukan.</p>
                                            </div>
                                        @endforelse
                                    </div>

                                    <!--pagination  -->
                                    <div
                                        class="mt-pagination-wrap d-flex align-items-center justify-content-between mt-20 flex-wrap">
                                        <div class="mt-pagination mb-20">
                                            {{-- Tombol Prev --}}
                                            @if ($produks->onFirstPage())
                                                <span class="button disabled"><i class="fa-regular fa-chevron-left"></i>
                                                    Prev</span>
                                            @else
                                                <a href="{{ $produks->previousPageUrl() }}" class="button">
                                                    <i class="fa-regular fa-chevron-left"></i> Prev
                                                </a>
                                            @endif

                                            {{-- Nomor Halaman --}}
                                            @for ($i = 1; $i <= $produks->lastPage(); $i++)
                                                @if ($i == $produks->currentPage())
                                                    <a href="#" class="active">{{ $i }}</a>
                                                @elseif ($i == 1 || $i == $produks->lastPage() || abs($produks->currentPage() - $i) <= 2)
                                                    <a href="{{ $produks->url($i) }}">{{ $i }}</a>
                                                @elseif ($i == 2 || $i == $produks->lastPage() - 1)
                                                    <span>...</span>
                                                @endif
                                            @endfor

                                            {{-- Tombol Next --}}
                                            @if ($produks->hasMorePages())
                                                <a href="{{ $produks->nextPageUrl() }}" class="button">
                                                    Next <i class="fa-regular fa-chevron-right"></i>
                                                </a>
                                            @else
                                                <span class="button disabled">Next <i
                                                        class="fa-regular fa-chevron-right"></i></span>
                                            @endif
                                        </div>

                                        <div class="mt-pagination-sort mb-20">
                                            <div class="ddd">
                                                <span>
                                                    Menampilkan {{ $produks->firstItem() }} hingga
                                                    {{ $produks->lastItem() }} dari {{ $produks->total() }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Shop Area -->
@endsection
