@extends('layouts.first')
@section('title')
    Registrasi
@endsection
@section('content')
    <!--  -->
    <section class="mt-login-area pt-60 pb-140 p-relative z-index-1 fix">
        <div class="container">
            <div class="mt-login-wrapper" data-background="{{ URL::asset('dist/img/contact/login-bg.jpg') }}">
                <div class="row align-items-center">
                    <div class="col-xl-12 col-lg-12">
                        <div class="mt-login-top text-center mb-40">
                            <h3 class="mt-login-title">Registrasi</h3>
                            <span>Daftar untuk mendapatkan akun</span>
                        </div>
                    </div>
                    <form action="{{ route('customer.register.store') }}" method="POST">
                        @csrf
                        <div class="col-xl-12 col-lg-12">
                            <div class="mt-login-wrap mr-30">
                                <div class="mt-login-option">
                                    <div class="mt-login-input-wrapper mb-20">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="hidden" name="redirect" value="{{ $redirect }}">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mt-checkout-input">
                                                            <input type="text" placeholder="name"
                                                                class="@error('name') is-invalid @enderror" id="name"
                                                                name="name" value="{{ old('name') }}">
                                                        </div>
                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="mt-checkout-input">
                                                            <input type="email" placeholder="email"
                                                                class="@error('email') is-invalid @enderror" id="email"
                                                                name="email" value="{{ old('email') }}">
                                                        </div>
                                                        @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="mt-checkout-input">
                                                            <input type="text" placeholder="Username"
                                                                class="@error('username') is-invalid @enderror"
                                                                id="username" name="username"
                                                                value="{{ old('username') }}">
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
                                                                class="@error('password') is-invalid @enderror"
                                                                id="password" name="password"
                                                                value="{{ old('password') }}">
                                                        </div>
                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mt-checkout-input">
                                                            <input type="text" placeholder="Nomor Telepon"
                                                                class="@error('telepon') is-invalid @enderror"
                                                                id="telepon" name="telepon" value="{{ old('telepon') }}">
                                                        </div>
                                                        @error('telepon')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="mt-checkout-input">
                                                            <select class="@error('village_id') is-invalid @enderror"
                                                                id="village_id" name="village_id">
                                                                <option hidden>Pilih Kelurahan</option>
                                                                @foreach ($villages as $village)
                                                                    <option value="{{ $village->id }}"
                                                                        @if (old('village_id') == $village->id) selected="selected" @endif>
                                                                        {{ $village->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @error('village_id')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="mt-checkout-input">
                                                            <textarea class="@error('alamat') is-invalid @enderror" rows="1" name="alamat" id="alamat"
                                                                placeholder="Alamat ...">{{ old('alamat') }}</textarea>
                                                        </div>
                                                        @error('alamat')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="mt-checkout-input">
                                                            <input type="text" placeholder="Kode Pos"
                                                                class="@error('kode_pos') is-invalid @enderror"
                                                                id="kode_pos" name="kode_pos"
                                                                value="{{ old('kode_pos') }}">
                                                        </div>
                                                        @error('kode_pos')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <button type="submit" class="mt-btn-2 w-100">
                                                    <span>Daftar</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-login-account text-center mb-30">
                                        <p>Sudah Punya Akun?
                                            <a href="{{ route('customer.login', ['redirect' => request('redirect')]) }}">
                                                Login</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--  -->
@endsection
