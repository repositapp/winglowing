<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="@if (Auth::user()->avatar != '') {{ asset('storage/' . Auth::user()->avatar) }}@else{{ URL::asset('build/dist/img/user2-160x160.jpg') }} @endif"
                    class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        {{-- <hr> --}}
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="main-utama">
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-dashboard"></i><span>Dashboard</span>
                </a>
            </li>
            <li class="header">MAIN NAVIGATION</li>
            <li
                class="treeview {{ Request::is('admin/kategori*', 'admin/rekening*', 'admin/ongkir*') ? 'active menu-open' : '' }}">
                <a href="#">
                    <i class="fa fa-cubes"></i>
                    <span>Master Data</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('admin/kategori*') ? 'active' : '' }}"><a
                            href="{{ route('kategori.index') }}"><i class="fa fa-circle-o"></i> Kategori Produk</a></li>
                    <li class="{{ Request::is('admin/rekening*') ? 'active' : '' }}"><a
                            href="{{ route('rekening.index') }}"><i class="fa fa-circle-o"></i> Rekening</a></li>
                    <li class="{{ Request::is('admin/ongkir*') ? 'active' : '' }}"><a
                            href="{{ route('ongkir.index') }}"><i class="fa fa-circle-o"></i> Ongkos Kirim</a></li>
                </ul>
            </li>
            <li class="{{ Request::is('admin/produk*') ? 'active' : '' }}">
                <a href="{{ route('produk.index') }}"><i class="fa fa-archive"></i><span>Produk</span></a>
            </li>
            <li class="treeview {{ Request::is('admin/transaksi*') ? 'active menu-open' : '' }}">
                <a href="#">
                    <i class="fa fa-random"></i> <span>Transaksi</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('transaksi/baru') ? 'active' : '' }}">
                        <a href="{{ route('transaksi.index', 'baru') }}"><i class="fa fa-circle-o"></i> Pesanan
                            Baru</a>
                    </li>
                    <li class="{{ Request::is('transaksi/packing') ? 'active' : '' }}">
                        <a href="{{ route('transaksi.index', 'packing') }}"><i class="fa fa-circle-o"></i> Pesanan
                            Packing</a>
                    </li>
                    <li class="{{ Request::is('transaksi/pengiriman') ? 'active' : '' }}">
                        <a href="{{ route('transaksi.index', 'pengiriman') }}"><i class="fa fa-circle-o"></i> Pesanan
                            Pengiriman</a>
                    </li>
                    <li class="{{ Request::is('transaksi/diterima') ? 'active' : '' }}">
                        <a href="{{ route('transaksi.index', 'diterima') }}"><i class="fa fa-circle-o"></i> Pesanan
                            Diterima</a>
                    </li>
                    <li class="{{ Request::is('transaksi/dibatalkan') ? 'active' : '' }}">
                        <a href="{{ route('transaksi.index', 'dibatalkan') }}"><i class="fa fa-circle-o"></i> Pesanan
                            Dibatalkan</a>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ Request::is('admin/laporan*') ? 'active menu-open' : '' }}">
                <a href="#">
                    <i class="fa fa-print"></i> <span>Laporan</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('admin/laporan/products') ? 'active' : '' }}"><a
                            href="{{ route('laporan.products') }}"><i class="fa fa-circle-o"></i> Laporan Produk</a>
                    </li>
                    <li class="{{ Request::is('admin/laporan/low_stock') ? 'active' : '' }}"><a
                            href="{{ route('laporan.low_stock') }}"><i class="fa fa-circle-o"></i> Laporan Stok
                            Menipis</a></li>
                    <li class="{{ Request::is('admin/laporan/sales') ? 'active' : '' }}"><a
                            href="{{ route('laporan.sales') }}"><i class="fa fa-circle-o"></i> Laporan Penjualan</a>
                    </li>
                    <li class="{{ Request::is('admin/laporan/financial') ? 'active' : '' }}"><a
                            href="{{ route('laporan.financial') }}"><i class="fa fa-circle-o"></i> Laporan Keuangan</a>
                    </li>
                </ul>
            </li>
            <li class="header">More</li>
            <li
                class="treeview {{ Request::is('admin/users*', 'admin/kategori_upz*', 'admin/golongan_mustahik*', 'admin/zakat*', 'admin/aplikasi*', 'admin/bank*') ? 'active menu-open' : '' }}">
                <a href="#">
                    <i class="fa fa-gears"></i> <span>Pengaturan</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('admin/users*') ? 'active' : '' }}"><a
                            href="{{ route('users.index') }}"><i class="fa fa-circle-o"></i> Akun Pengguna</a></li>
                    <li class="{{ Request::is('admin/aplikasi*') ? 'active' : '' }}"><a
                            href="{{ route('aplikasi.index') }}"><i class="fa fa-circle-o"></i> Aplikasi</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void();"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                        class="fa fa-power-off"></i><span>Keluar</span></a>
                <form id="logout-form" action="method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
