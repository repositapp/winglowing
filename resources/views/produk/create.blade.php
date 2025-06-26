@extends('layouts.master')
@section('title')
    Tambah Produk
@endsection
@push('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ URL::asset('build/bower_components/select2/dist/css/select2.min.css') }}">
@endpush
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Produk
        @endslot
        @slot('li_2')
            Data Produk
        @endslot
        @slot('title')
            Tambah Produk
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">Form Input</h3>
                <div class="pull-right box-tools">
                    <a href="{{ route('produk.index') }}" class="btn btn-social btn-sm btn-default">
                        <i class="fa fa-reply"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="box-body">
                <form class="form-horizontal" action="{{ route('produk.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="kategori_id" class="col-sm-2 control-label">Kategori <span
                                class="text-red">*</span></label>

                        <div class="col-sm-10">
                            <select class="form-control select2 @error('kategori_id') is-invalid @enderror" id="kategori_id"
                                name="kategori_id">
                                <option value="" hidden>-- Choose --</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}"
                                        @if (old('kategori_id') == $kategori->id) selected="selected" @endif> {{ $kategori->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama_produk" class="col-sm-2 control-label">Nama Produk <span
                                class="text-red">*</span></label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('nama_produk') is-invalid @enderror"
                                id="nama_produk" name="nama_produk" value="{{ old('nama_produk') }}"
                                placeholder="Nama Produk">
                            @error('nama_produk')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="brand" class="col-sm-2 control-label">Brand Produk </label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('brand') is-invalid @enderror" id="brand"
                                name="brand" value="{{ old('brand') }}" placeholder="Brand Produk">
                            @error('brand')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price" class="col-sm-2 control-label">Harga Jual <span
                                class="text-red">*</span></label>

                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Rp.
                                </div>
                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                    id="price" name="price" value="{{ old('price') }}" placeholder="Harga Jual">
                            </div>
                            @error('price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cost_price" class="col-sm-2 control-label">Harga Modal <span
                                class="text-red">*</span></label>

                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Rp.
                                </div>
                                <input type="number" class="form-control @error('cost_price') is-invalid @enderror"
                                    id="cost_price" name="cost_price" value="{{ old('cost_price') }}"
                                    placeholder="Harga Modal">
                            </div>
                            @error('cost_price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="stock" class="col-sm-2 control-label">Stok Produk <span
                                class="text-red">*</span></label>

                        <div class="col-sm-10">
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock"
                                name="stock" value="{{ old('stock') }}" placeholder="Stok Produk">
                            @error('stock')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="discount" class="col-sm-2 control-label">Diskon </label>

                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="number" class="form-control @error('discount') is-invalid @enderror"
                                    id="discount" name="discount" value="{{ old('discount', 0) }}" placeholder="Diskon">
                                <div class="input-group-addon">
                                    %
                                </div>
                            </div>
                            @error('discount')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-sm-2 control-label">Deskripsi <span
                                class="text-red">*</span></label>

                        <div class="col-sm-10">
                            <textarea class="tinymce  @error('description') is-invalid @enderror" rows="10" name="description"
                                id="description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div id="image-fields">
                        <div class="form-group">
                            <label for="gambar" class="col-sm-2 control-label">Gambar Produk <span
                                    class="text-red">*</span></label>

                            <div class="col-sm-9 mb-2">
                                <input type="file" id="gambar" name="gambar[]"
                                    class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                                <small class="text-danger">Ukuran File Maksimal 2MB</small>
                            </div>
                            <div class="col-sm-1 mb-2">
                                <button class="btn btn-success btn-add" type="button"><i
                                        class="fa fa-plus"></i></button>
                            </div>
                            @error('gambar')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9 text-right">
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
    <!-- tinymce -->
    <script src="{{ URL::asset('build/plugins/tinymce/tinymce.js') }}"></script>
    <script src="{{ URL::asset('build/plugins/tinymce/form-editor-tiny.init.js') }}"></script>

    <script>
        $(function() {
            //Initialize Select2 Elements
            $('#kategori_id').select2();
        });

        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('image-fields');

            container.addEventListener('click', function(e) {
                if (e.target.closest('.btn-add')) {
                    e.preventDefault();
                    let newField = document.createElement('div');
                    newField.classList.add('form-group', 'mb-2');
                    newField.innerHTML = `
                    <label for="gambar" class="col-sm-2 control-label">Dokumentasi <span
                            class="text-red">*</span></label>

                    <div class="col-sm-9 mb-2">
                        <input type="file" id="gambar" name="gambar[]" class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                        <small class="text-danger">Ukuran File Maksimal 2MB</small>
                    </div>
                    <div class="col-sm-1 mb-2">
                        <button class="btn btn-danger btn-remove" type="button"><i class="fa fa-trash"></i></button>
                    </div>`;
                    container.appendChild(newField);
                }
                if (e.target.closest('.btn-remove')) {
                    e.preventDefault();
                    e.target.closest('.form-group').remove();
                }
            });
        });
    </script>
@endpush
