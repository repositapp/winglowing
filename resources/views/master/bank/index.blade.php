@extends('layouts.master')
@section('title')
    Rekening Bank
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
            Rekening Bank
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-success">
            <div class="box-header">
                <div class="row align-items-center">
                    <div class="col-md-6 align-items-center">
                        <form action="{{ route('rekening.index') }}">
                            <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                                <input type="text" name="search" class="form-control pull-right" placeholder="Search..."
                                    value="{{ request('search') }}">

                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('rekening.create') }}" class="btn btn-social btn-sm btn-success">
                            <i class="fa fa-plus"></i> Tambah Data
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 40px">No.</th>
                            <th>Logo Bank</th>
                            <th>Nama Bank</th>
                            <th>Nomor Rekening</th>
                            <th>Atas Nama</th>
                            <th class="text-center" style="width: 80px">Aksi</th>
                        </tr>
                    </thead>
                    <Tbody>
                        @forelse ($banks as $bank)
                            <tr>
                                <td class="text-center">{{ $banks->firstItem() + $loop->index }}</td>
                                <td width="200px">
                                    <img src="{{ asset('storage/' . $bank->logo_bank) }}" class="img-fluid mb-3 d-block"
                                        alt="Logo Bank" width="20%">
                                </td>
                                <td>{{ $bank->nama_bank }}</td>
                                <td>{{ $bank->rekening }}</td>
                                <td>{{ $bank->pemilik }}</td>
                                <td class="text-center">
                                    <div class="btn-group d-flex">
                                        <a href="{{ route('rekening.edit', $bank->id) }}"
                                            class="btn btn-default btn-sm text-green"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('rekening.destroy', $bank->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-default btn-sm text-red"><i
                                                    class="fa fa-trash-o"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    Data rekening belum Tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </Tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                <div class="row align-items-center">
                    <div class="col-md-6 align-items-center">
                        Menampilkan
                        {{ $banks->firstItem() }}
                        hingga
                        {{ $banks->lastItem() }}
                        dari
                        {{ $banks->total() }} entri
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            {{ $banks->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
