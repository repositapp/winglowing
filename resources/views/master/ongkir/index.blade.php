@extends('layouts.master')
@section('title')
    Ongkos Kirim
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Master Data
        @endslot
        @slot('li_2')
            Ongkos Kirim
        @endslot
        @slot('title')
            Ongkos Kirim
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-success">
            <div class="box-header">
                <div class="row align-items-center">
                    <div class="col-md-6 align-items-center">
                        <form action="{{ route('ongkir.index') }}">
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
                        <a href="{{ route('ongkir.create') }}" class="btn btn-social btn-sm btn-success">
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
                            <th>Kota</th>
                            <th>Kecamatan</th>
                            <th>Kelurahan</th>
                            <th>Ongkos Kirim</th>
                            <th class="text-center" style="width: 80px">Aksi</th>
                        </tr>
                    </thead>
                    <Tbody>
                        @forelse ($ongkirs as $ongkir)
                            <tr>
                                <td class="text-center">{{ $ongkirs->firstItem() + $loop->index }}</td>
                                <td>{{ $ongkir->city->name }}</td>
                                <td>{{ $ongkir->district->name }}</td>
                                <td>{{ $ongkir->village->name }}</td>
                                <td>Rp{{ number_format($ongkir->biaya, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <div class="btn-group d-flex">
                                        <a href="{{ route('ongkir.edit', $ongkir->id) }}"
                                            class="btn btn-default btn-sm text-green"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('ongkir.destroy', $ongkir->id) }}" method="POST"
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
                                    Data ongkos kirim belum Tersedia.
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
                        {{ $ongkirs->firstItem() }}
                        hingga
                        {{ $ongkirs->lastItem() }}
                        dari
                        {{ $ongkirs->total() }} entri
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            {{ $ongkirs->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
