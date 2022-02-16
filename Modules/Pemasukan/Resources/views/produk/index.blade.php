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
                  <a  href="{{ route('produk-create') }}" type="button" class="btn btn-info"> Produk Baru </a>
            </div>

            <div style="width: 100%; padding-left: -10px;">
            <div class="table-responsive">
            <table id="table_result" class="table table-bordered data-table display nowrap" style="width:100%">
            <thead style="text-align:center;">
                  <tr>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th style="width: 30%">Aksi</th>
                  </tr>
            </thead>
            </table>
            </div>
            </div>

            <hr>
            
            <div class="alert alert-light">
                <small> Tips : Tabel produk berisikan produk jual, produk jual akan terpakai pada transaksi pemasukan toko.</small>
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
    rowReorder: {
        selector: 'td:nth-child(2)'
    },
    responsive: true,
    ajax: "#",
    columns: [
            {data: 'nama_produk', name: 'nama_produk'},
            {data: 'harga', name: 'harga'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
    ]
    });

})

</script>

@endpush