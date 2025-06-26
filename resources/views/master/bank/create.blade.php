@extends('layouts.master')
@section('title')
    Tambah Rekening
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Master Data
        @endslot
        @slot('li_2')
            Rekening Bank
        @endslot
        @slot('title')
            Tambah Rekening
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">Form Input</h3>
                <div class="pull-right box-tools">
                    <a href="{{ route('rekening.index') }}" class="btn btn-social btn-sm btn-default">
                        <i class="fa fa-reply"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="box-body">
                <form class="form-horizontal" action="{{ route('rekening.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="nama_bank" class="col-sm-2 control-label">Nama Bank</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('nama_bank') is-invalid @enderror"
                                id="nama_bank" name="nama_bank" value="{{ old('nama_bank') }}" placeholder="Nama Bank">
                            @error('nama_bank')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="rekening" class="col-sm-2 control-label">Rekening</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('rekening') is-invalid @enderror"
                                id="rekening" name="rekening" value="{{ old('rekening') }}" placeholder="Nomor Rekening">
                            @error('rekening')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pemilik" class="col-sm-2 control-label">Pemilik</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('pemilik') is-invalid @enderror" id="pemilik"
                                name="pemilik" value="{{ old('pemilik') }}" placeholder="Pemilik">
                            @error('pemilik')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="logo_bank" class="col-sm-2 control-label">Logo Bank</label>

                        <div class="col-sm-10">
                            <input type="file" class="form-control @error('logo_bank') is-invalid @enderror"
                                id="logo_bank" name="logo_bank" placeholder="Logo Bank">
                            <small class="text-danger">Ukuran File Maksimal 1MB</small>
                            @error('logo_bank')
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
