@extends('layouts.first')
@section('title')
    Login
@endsection
@section('content')
    <!--  -->
    <section class="mt-login-area pt-60 pb-140 p-relative z-index-1 fix">
        <div class="container">
            <div class="mt-login-wrapper" data-background="{{ URL::asset('dist/img/contact/login-bg.jpg') }}">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-lg-6">
                        <div class="mt-login-wrap mr-30">
                            <div class="mt-login-top text-center mb-40">
                                <h3 class="mt-login-title">Login</h3>
                                <span>Masuk ke akun anda</span>
                            </div>
                            <div class="mt-login-option">
                                <div class="mt-login-input-wrapper mb-20">
                                    <form action="{{ route('customer.authentication') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="redirect" value="{{ $redirect }}">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mt-checkout-input">
                                                    <input type="text" placeholder="Username"
                                                        class="@error('username') is-invalid @enderror" id="username"
                                                        name="username">
                                                </div>
                                                @error('username')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mt-checkout-input p-relative">
                                                    <input type="password" placeholder="Password"
                                                        class="@error('password') is-invalid @enderror" id="password"
                                                        name="password">
                                                </div>
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="mt-btn-2 w-100">
                                                    <span>Login</span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="mt-login-account text-center mb-30">
                                    <p>Belum Punya Akun?
                                        <a href="{{ route('customer.register', ['redirect' => request('redirect')]) }}">
                                            Registrasi</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="mt-login-thumb br-40 text-center text-lg-end wow img-custom-anim-top"
                            data-wow-duration="1.5s" data-wow-delay="0.1s">
                            <img src="{{ URL::asset('dist/img/banner/hp-banner-1-1.jpg') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--  -->
@endsection
