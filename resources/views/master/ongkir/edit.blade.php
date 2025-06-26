@extends('layouts.master')
@section('title')
    Tambah Ongkos Kirim
@endsection
@push('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ URL::asset('build/bower_components/select2/dist/css/select2.min.css') }}">
@endpush
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Master Data
        @endslot
        @slot('li_2')
            Ongkos Kirim
        @endslot
        @slot('title')
            Tambah Ongkos Kirim
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">Form Input</h3>
                <div class="pull-right box-tools">
                    <a href="{{ route('ongkir.index') }}" class="btn btn-social btn-sm btn-default">
                        <i class="fa fa-reply"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="box-body">
                <form class="form-horizontal" action="{{ route('ongkir.update', $ongkir->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="city_id" class="col-sm-2 control-label">Kota <span class="text-red">*</span></label>

                        <div class="col-sm-10">
                            <select class="form-control select2 @error('city_id') is-invalid @enderror" id="city_id"
                                name="city_id">
                                <option hidden>-- Pilih Kota --</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}"
                                        {{ old('city_id', $ongkir->city_id ?? '') == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('city_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="district_id" class="col-sm-2 control-label">Kecamatan <span
                                class="text-red">*</span></label>

                        <div class="col-sm-10">
                            <select class="form-control select2 @error('district_id') is-invalid @enderror" id="district_id"
                                name="district_id">
                                <option hidden>-- Pilih Kecamatan --</option>
                                @isset($districts)
                                    @foreach ($districts as $district)
                                        <option value="{{ $district->id }}"
                                            {{ old('district_id', $ongkir->district_id ?? '') == $district->id ? 'selected' : '' }}>
                                            {{ $district->name }}
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                            @error('district_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="village_id" class="col-sm-2 control-label">Kelurahan <span
                                class="text-red">*</span></label>

                        <div class="col-sm-10">
                            <select class="form-control select2 @error('village_id') is-invalid @enderror" id="village_id"
                                name="village_id">
                                <option hidden>-- Pilih Kelurahan --</option>
                                @isset($villages)
                                    @foreach ($villages as $village)
                                        <option value="{{ $village->id }}"
                                            {{ old('village_id', $ongkir->village_id ?? '') == $village->id ? 'selected' : '' }}>
                                            {{ $village->name }}
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                            @error('village_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="biaya" class="col-sm-2 control-label">Biaya <span class="text-red">*</span></label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('biaya') is-invalid @enderror" id="biaya"
                                name="biaya" value="{{ old('biaya', $ongkir->biaya) }}" placeholder="Biaya Pengiriman">
                            @error('biaya')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10 text-right">
                            <button type="submit" class="btn btn-social btn-success btn-sm"><i class="fa fa-save"></i>
                                Simpan</button>
                        </div>
                    </div>
                    <p>Catatan : (<span class="text-red">*</span>) Wajib diisi.</p>
                </form>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <!-- Select2 -->
    <script src="{{ URL::asset('build/bower_components/select2/dist/js/select2.full.min.js') }}"></script>

    <script>
        $(function() {
            //Initialize Select2 Elements
            $('#city_id').select2();
            $('#district_id').select2();
            $('#village_id').select2();
        });

        $(document).ready(function() {
            $('#city_id').on('change', function() {
                var cityId = $(this).val();
                $.get('/admin/get-districts/' + cityId, function(data) {
                    $('#district_id').empty().append(
                        '<option hidden>-- Pilih Kecamatan --</option>');
                    $('#village_id').empty().append(
                        '<option hidden>-- Pilih Kelurahan --</option>');
                    data.forEach(d => $('#district_id').append(
                        `<option value="${d.id}">${d.name}</option>`));
                });
            });

            $('#district_id').on('change', function() {
                var districtId = $(this).val();
                $.get('/admin/get-villages/' + districtId, function(data) {
                    $('#village_id').empty().append(
                        '<option hidden>-- Pilih Kelurahan --</option>');
                    data.forEach(v => $('#village_id').append(
                        `<option value="${v.id}">${v.name}</option>`));
                });
            });
        });
    </script>
@endpush
