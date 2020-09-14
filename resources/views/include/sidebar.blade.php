<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
    <a href="{{route('home')}}">SPSS BPS RIAU</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
    <a href="{{route('home')}}">BPS</a>
    </div>
    <ul class="sidebar-menu">

    @if(Auth::user()->account_type == User::ACCOUNT_TYPE_ADMIN)
    <li class="menu-header">Data SLS</li>
        <!-- <li class="nav-item dropdown active"> Set To Active-->
        <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-table"></i><span>Master</span></a>
        <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{route('master-sls')}}">Master SLS</a></li>
            <li><a class="nav-link" href="{{route('import-sls')}}">Import Data</a></li>
        </ul>
        </li>
    @endif
        <li class="menu-header">Input Data</li>
        <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-folder"></i> <span>Input Data</span></a>
        <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{route('transaksi-spss')}}">Input Data SPSS</a></li>
        </ul>
        </li>
    
        <li class="menu-header">Laporan</li>
        <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-folder"></i> <span>Pegawai</span></a>
        <ul class="dropdown-menu">
            @if(Auth::user()->account_type == User::ACCOUNT_TYPE_ADMIN)
            <li><a class="nav-link" href="{{route('laporan-partisipasi')}}">Laporan Partisipasi</a></li>
            @endif
            <li><a class="nav-link" href="{{route('cetak-dok-kegiatan')}}">Cetak Laporan Kegiatan</a></li>
        </ul>
        </li>

        @if(Auth::user()->account_type == User::ACCOUNT_TYPE_ADMIN)
        <li class="menu-header">Pengaturan</li>
        <li class="nav-item dropdown">
        @if(Auth::user()->kabupaten_id == null)
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-map-marker-alt"></i> <span>Wilayah</span></a>
        <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{route('kabupaten')}}">Kabupaten</a></li>
            <li><a class="nav-link" href="{{route('kecamatan')}}">Kecamatan</a></li>
            <li><a class="nav-link" href="{{route('desa')}}">Desa</a></li>
            <li><a class="nav-link" href="{{route('import-wilayah')}}">Import Data</a></li>
        </ul>
        @endif
        </li>
        <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users"></i> <span>User</span></a>
        <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{route('index-user')}}">Kelola User</a></li>
            <li><a class="nav-link" href="{{route('import-user')}}">Import Data</a></li>
        </ul>
        </li>
        <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-exchange-alt"></i> <span>Transfer</span></a>
        <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{route('transfer-sls')}}">Transfer Data SLS</a></li>
        </ul>
        </li>
        <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-folder"></i> <span>Export Data</span></a>
        <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{route('export-data')}}">Export Data</a></li>
        </ul>
        </li>
    @endif

    </ul>
</aside>