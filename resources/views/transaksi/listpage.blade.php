@extends('master')
 
@section('title', '{{ $title }}')

@section('alert')

@if(Session::has('alert_success'))
  @component('components.alert')
        @slot('class')
            success
        @endslot
        @slot('title')
            Terimakasih
        @endslot
        @slot('message')
            {{ session('alert_success') }}
        @endslot
  @endcomponent
@elseif(Session::has('alert_error'))
  @component('components.alert')
        @slot('class')
            error
        @endslot
        @slot('title')
            Cek Kembali
        @endslot
        @slot('message')
            {{ session('alert_error') }}
        @endslot
  @endcomponent 
@endif

@endsection

@section('content')

<div class="row">
<div class="col-lg-12 col-md-12 col-12 col-sm-12">
    <div class="card">
    <div class="card-header">
        <h4>{{ $title }}</h4>
    </div>
    <div class="card-body">
        
        <div style="padding-bottom: 20px">
            <a  href="{{ route('transaksi') }}" type="button" class="btn btn-info"> Import Transaksi Baru </a>
            <a href="{{ route('report-transaksi') }}" type="button" class="btn btn-info float-right"> <i class="fas fa-search"></i> &nbsp Pencarian Lanjutan </a>
        </div>

        <div style="width: 100%; padding-left: -10px;">
        <div class="table-responsive">
        <table id="table_result" class="table table-bordered data-table display nowrap" style="width:100%">
        <thead style="text-align:center;">
            <tr>
                <th>Nomor Resi</th>
                <th>Username</th>
                <th>Nama Penerima</th>
                <th>Nomor Pesanan</th>
                <th>Tanggal Pesanan</th>
                <th>Jasa Kirim</th>
                <th style="width: 30%">Aksi</th>
            </tr>
        </thead>
        </table>
        </div>
        </div>

        <hr>
        
        <div class="alert alert-light">
            <small> Hanya menampilkan 100 transaksi terakhir | Pencarian spesifik transaksi bedasarkan periode dapat diakses melalui tombol pencarian &nbsp <i class="fas fa-search"></i></small>
        </div>  
    </div>
</div>
</div>


@endsection

@push('scripts')

<script type="text/javascript">

let table;

$(function () {

    table = $('#table_result').DataTable({
    processing: true,
    serverSide: true,
    ordering:false,
    aoColumnDefs: [
        { "bSortable": false}
    ],
    rowReorder: {
        selector: 'td:nth-child(2)'
    },
    responsive: true,
    ajax: "{{route('listpage-transaksi')}}",
    columns: [
        {data: 'no_resi', name: 'no_resi'},
        {data: 'username_pembeli', name: 'username_pembeli'},
        {data: 'nama_pembeli', name: 'nama_pembeli'},
        {data: 'no_pesanan', name: 'no_pesanan'},
        {data: 'tgl_pesanan_dibuat', name: 'tgl_pesanan_dibuat'},
        {data: 'jasa_kirim', name: 'jasa_kirim'},            
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]
    });

})

</script>

@endpush