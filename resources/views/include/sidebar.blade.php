<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
    <a href="{{route('home')}}">Cetak Resi</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
    <a href="{{route('home')}}">CR</a>
    </div>
    <ul class="sidebar-menu">

        @if($active == 'home') <li class="active"> @else <li> @endif
            <a class="nav-link" href="{{route('home')}}"><i class="fas fa-home"></i> <span>Dashboard</span></a>
        </li>

        @if($active == 'transaksi') <li class="active"> @else <li> @endif
            <a class="nav-link" href="{{route('transaksi')}}"><i class="fas fa-exchange-alt"></i> <span>Transaksi Import</span></a>
        </li>

        @if($active == 'shopeepay') <li class="active"> @else <li> @endif
            <a class="nav-link" href="{{route('shopeepay')}}"><i class="fas fa-dollar-sign"></i> <span>Shopee Pay Import</span></a>
        </li>

        @if($active == 'customer') <li class="active"> @else <li> @endif
            <a class="nav-link" href="{{route('index-customer')}}"><i class="fas fa-male"></i> <span>Database Customer</span></a>
        </li>

        @if($active == 'cetak-label') <li class="active"> @else <li> @endif
            <a class="nav-link" href="{{route('cetak-label')}}"><i class="fas fa-barcode"></i> <span>Cetak Label</span></a>
        </li>

        @if($active == 'transaksi-table' || $active == 'transaksi-grafik') <li class="nav-item dropdown active"> @else <li> @endif
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
            <i class="fas fa-file"></i> <span>Laporan</span>
        </a>
        
        <ul class="dropdown-menu">
            @if($active == 'transaksi-table') <li class="active"> @else <li> @endif
                <a class="nav-link" href="{{route('report-transaksi')}}">Daftar Transaksi</a>
            </li>
            @if($active == 'transaksi-grafik') <li class="active"> @else <li> @endif
                <a class="nav-link" href="{{route('report-transaksi-grafik')}}">Grafik Transaksi</a>
            </li>
        </ul>
        
        </li>


        @if($active == 'user') <li class="nav-item dropdown active"> @else <li> @endif
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users"></i> <span>User</span></a>
        <ul class="dropdown-menu">
            @if($active == 'user') <li class="active"> @else <li> @endif
                <a class="nav-link" href="{{route('index-user')}}">Kelola User</a>
            </li>
        </ul>
        </li>

        @if($active == 'pengaturan' || $active == 'toko') <li class="nav-item dropdown active"> @else <li> @endif
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cog"></i> <span>Pengaturan</span></a>
        <ul class="dropdown-menu">
            @if($active == 'toko') <li class="active"> @else <li> @endif
                <a class="nav-link" href="{{ route('toko-index') }}">Kelola Toko</a>
            </li>
        </ul>
        </li>

    
    </ul>
</aside>