@extends('layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Transaksi
        @endslot
        @slot('li_2')
            {{ $title }}
        @endslot
        @slot('title')
            {{ $title }}
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-success">
            <div class="box-header">
                <div class="row align-items-center">
                    <div class="col-md-12 align-items-center text-right">
                        <form action="{{ route('transaksi.index', $status) }}">
                            <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                                <input type="text" name="search" class="form-control pull-right" placeholder="Search..."
                                    value="{{ request('search') }}">

                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 40px">No.</th>
                            <th>Kode Transaksi</th>
                            <th>Nama Pelanggan</th>
                            <th>Total Bayar</th>
                            <th>Metode Bayar</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th class="text-center" style="width: 80px">Aksi</th>
                        </tr>
                    </thead>
                    <Tbody>
                        @forelse ($transaksis as $transaksi)
                            <tr>
                                <td class="text-center">{{ $transaksis->firstItem() + $loop->index }}</td>
                                <td>{{ $transaksi->kode_transaksi }}</td>
                                <td>{{ $transaksi->biodata->nama_lengkap ?? '-' }}</td>
                                <td>Rp{{ number_format($transaksi->grand_total, 0, ',', '.') }}</td>
                                <td>
                                    @if ($transaksi->metode_pembayaran == 'cod')
                                        COD
                                    @else
                                        <a href="#" data-toggle="modal"
                                            data-target="#modal-bukti-transaksi{{ $transaksi->id }}">Transfer
                                            Bank</a>
                                    @endif
                                </td>
                                <td><span class="label label-info">{{ ucfirst($transaksi->status) }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($transaksi->created_at)->format('d M Y') }}</td>
                                <td class="text-center">
                                    <div class="btn-group d-flex">
                                        <a href="{{ route('transaksi.show', $transaksi->kode_transaksi) }}"
                                            class="btn btn-default btn-sm text-info"><i class="fa fa-eye"></i></a>
                                        @if ($transaksi->metode_pembayaran == 'transfer')
                                            @if ($transaksi->image_transfer != null)
                                                <form action="{{ route('transaksi.update', $transaksi->kode_transaksi) }}"
                                                    method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="packing">
                                                    <button class="btn btn-default btn-sm text-green"
                                                        onclick="return confirm('Pindahkan ke Packing?')">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <form action="{{ route('transaksi.update', $transaksi->kode_transaksi) }}"
                                                method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="packing">
                                                <button class="btn btn-default btn-sm text-green"
                                                    onclick="return confirm('Pindahkan ke Packing?')">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('transaksi.cancel', $transaksi->kode_transaksi) }}"
                                            method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-default btn-sm text-red"
                                                onclick="return confirm('Yakin batalkan pesanan ini?')">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="modal-bukti-transaksi{{ $transaksi->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">Bukti Transaksi</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-center">
                                                @if ($transaksi->image_transfer != null)
                                                    <img src="{{ asset('storage/' . $transaksi->image_transfer) }}"
                                                        class="img-thumbnail" width="70%">
                                                @else
                                                    <div class="callout callout-danger">
                                                        <p>{{ $transaksi->biodata->nama_lengkap ?? '-' }} belum melakukan
                                                            pembayaran. Silahkan tunggu sebelum mengkonfirmasi pesanan</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default pull-left"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    Data Transaksi belum Tersedia.
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
                        {{ $transaksis->firstItem() }}
                        hingga
                        {{ $transaksis->lastItem() }}
                        dari
                        {{ $transaksis->total() }} entri
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            {{ $transaksis->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
