@extends('layouts.master')
@section('title')
    Tambah Kategori
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Master Data
        @endslot
        @slot('li_2')
            Kategori Produk
        @endslot
        @slot('title')
            Tambah Kategori
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">Form Input</h3>
                <div class="pull-right box-tools">
                    <a href="{{ route('kategori.index') }}" class="btn btn-social btn-sm btn-default">
                        <i class="fa fa-reply"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="box-body">
                <form class="form-horizontal" action="{{ route('kategori.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nama Kategori</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" placeholder="Nama Kategori">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="image_kategori" class="col-sm-2 control-label">Gambar Kategori</label>

                        <div class="col-sm-10">
                            <input type="file" class="form-control @error('image_kategori') is-invalid @enderror"
                                id="image_kategori" name="image_kategori" placeholder="Gambar Kategori">
                            <small class="text-danger">Ukuran File Maksimal 1MB</small>
                            @error('image_kategori')
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
                </form>
            </div>
        </div>
    </section>
@endsection
