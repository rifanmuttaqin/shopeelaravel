<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
    <a href="{{route('home')}}">Cetak Resi</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
    <a href="{{route('home')}}">CR</a>
    </div>
    <ul class="sidebar-menu">

        <li>
            <a class="nav-link" href="{{route('home')}}"><i class="fas fa-home"></i> <span>Dashboard</span></a>
        </li>

        <li>
            <a class="nav-link" href="{{route('transaksi')}}"><i class="fas fa-exchange-alt"></i> <span>Transaksi Import</span></a>
        </li>

        <li>
            <a class="nav-link" href="{{route('index-customer')}}"><i class="fas fa-male"></i> <span>Database Customer</span></a>
        </li>

        <li>
            <a class="nav-link" href="{{route('cetak-label')}}"><i class="fas fa-barcode"></i> <span>Cetak Label</span></a>
        </li>

        <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-file"></i> <span>Laporan</span></a>
        <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{route('report-transaksi')}}">Daftar Transaksi</a></li>
        </ul>
        </li>


        <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users"></i> <span>User</span></a>
        <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{route('index-user')}}">Kelola User</a></li>
        </ul>
        </li>

        <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cog"></i> <span>Pengaturan</span></a>
        <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ route('setting') }}">Kelola Aplikasi</a></li>
        </ul>
        </li>

    
    </ul>
</aside>