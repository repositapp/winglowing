@extends('layouts.master')
@section('title')
    Data Produk
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Produk
        @endslot
        @slot('li_2')
            Data Produk
        @endslot
        @slot('title')
            Data Produk
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-success">
            <div class="box-header">
                <div class="row align-items-center">
                    <div class="col-md-6 align-items-center">
                        <form action="{{ route('produk.index') }}">
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
                        <a href="{{ route('produk.create') }}" class="btn btn-social btn-sm btn-success">
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
                            <th>Kategori</th>
                            <th>Nama</th>
                            <th>Brand</th>
                            <th>Harga</th>
                            <th>Modal</th>
                            <th>Stok</th>
                            <th>Diskon</th>
                            <th class="text-center" style="width: 80px">Aksi</th>
                        </tr>
                    </thead>
                    <Tbody>
                        @forelse ($produks as $produk)
                            <tr>
                                <td class="text-center">{{ $produks->firstItem() + $loop->index }}</td>
                                <td>{{ $produk->kategori->name }}</td>
                                <td>{{ $produk->nama_produk }}</td>
                                <td>{{ $produk->brand }}</td>
                                <td>Rp.{{ number_format($produk->price, 0, ',', '.') }}</td>
                                <td>Rp.{{ number_format($produk->cost_price, 0, ',', '.') }}</td>
                                <td>{{ $produk->stock }}</td>
                                <td>{{ $produk->discount }}%</td>
                                <td class="text-center">
                                    <div class="btn-group d-flex">
                                        <a href="{{ route('produk.edit', $produk->id) }}"
                                            class="btn btn-default btn-sm text-green"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('produk.destroy', $produk->id) }}" method="POST"
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
                                <td colspan="9" class="text-center">
                                    Data Produk belum Tersedia.
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
                        {{ $produks->firstItem() }}
                        hingga
                        {{ $produks->lastItem() }}
                        dari
                        {{ $produks->total() }} entri
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            {{ $produks->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
