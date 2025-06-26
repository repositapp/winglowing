@extends('layouts.first')
@section('title')
    Checkout Keranjang
@endsection
@section('content')
    <!-- checkout area start -->
    <section class="mt-checkout-area pb-140 pt-60">
        <div class="container">
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <!-- checkout place order -->
                        <div class="mt-checkout-place">
                            <h3 class="mt-checkout-place-title mb-20">Produk <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20"
                                        fill="none">
                                        <path
                                            d="M9 1.82196L10.429 6.82929L10.5619 7.29477L11.0314 7.17707L16.0824 5.91098L12.4604 9.65222L12.1237 10L12.4604 10.3478L16.0824 14.089L11.0314 12.8229L10.5619 12.7052L10.429 13.1707L9 18.178L7.57097 13.1707L7.43813 12.7052L6.9686 12.8229L1.91761 14.089L5.53957 10.3478L5.87627 10L5.53957 9.65222L1.91761 5.91098L6.9686 7.17707L7.43813 7.29477L7.57097 6.82929L9 1.82196Z"
                                            fill="#FDD057" stroke="#060121"></path>
                                    </svg>
                                </span></h3>

                            <div class="mt-order-info-list mb-20">
                                <ul>
                                    <!-- item list -->
                                    @foreach ($keranjangs as $produk)
                                        <li class="mt-order-info-list-desc">
                                            <div class="d-flex align-items-center">
                                                <div class="mt-order-info-list-content">
                                                    <h4 class="mt-order-info-list-title">{{ $produk->produk->nama_produk }}
                                                    </h4>
                                                    <span>Rp.
                                                        {{ number_format($produk->produk->price - ($produk->produk->discount ?? 0), 0, ',', '.') }}</span>
                                                    <p>Jumlah ({{ $produk->qty }})</p>
                                                </div>
                                            </div>
                                            <div class="mt-order-info-list-price">
                                                <span>Rp.
                                                    {{ number_format(($produk->produk->price - ($produk->produk->discount ?? 0)) * $produk->qty, 0, ',', '.') }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                    <!-- subtotal -->
                                    <li class="mt-order-info-list-subtotal">
                                        <span>Subtotal</span>
                                        <span class="price">Rp. {{ number_format($total, 0, ',', '.') }}</span>
                                    </li>
                                    <!-- subtotal -->
                                    <li class="mt-order-info-list-subtotal">
                                        <span>Ongkir</span>
                                        <span class="price">Rp. {{ number_format($ongkir, 0, ',', '.') }}</span>
                                    </li>
                                    <!-- shipping -->
                                    <li class="mt-order-info-list-shipping">
                                        <span>Grand Total</span>
                                        <span class="price">Rp. {{ number_format($total + $ongkir, 0, ',', '.') }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 offset-lg-1 pt-70">
                        <!-- checkout place order -->
                        <div class="mt-checkout-place">
                            <div class="mt-checkout-payment">
                                <h4 class="mt-checkout-payment-title mb-15">Metode Pembayaran</h4>
                                <div class="mt-checkout-payment-item">
                                    <input type="radio" id="back_transfer" name="metode_pembayaran" value="transfer">
                                    <label for="back_transfer">Transfer Bank</label>
                                    <div class="mt-checkout-payment-desc direct-bank-transfer ml-25">
                                        <div class="mt-checkout-input">
                                            <select class="@error('rekening_id') is-invalid @enderror" id="rekening_id"
                                                name="rekening_id">
                                                <option hidden>Pilih Rekening</option>
                                                @foreach ($rekenings as $rekening)
                                                    <option value="{{ $rekening->id }}"
                                                        @if (old('rekening_id') == $rekening->id) selected="selected" @endif>
                                                        {{ $rekening->nama_bank }} - {{ $rekening->rekening }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-checkout-payment-item">
                                    <input type="radio" id="cod" name="metode_pembayaran" value="cod">
                                    <label for="cod">Cash on Delivery</label>
                                    <div class="mt-checkout-payment-desc cash-on-delivery">
                                        <p style="padding: 0px;">Pembayaran akan dilakukan saat barang telah anda terima.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-checkout-btn-wrapper" style="text-align: right;">
                                <button type="submit" class="mt-btn"><span>Konfirmasi Order</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- checkout area end -->
@endsection
