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
            <a  href="{{ route('beritaacara-create') }}" type="button" class="btn btn-info"> Tulis Berita Acara </a>
        </div>

        <div style="width: 100%; padding-left: -10px;">
        <div class="table-responsive">
        <table id="table_result" class="table table-bordered data-table display nowrap" style="width:100%">
        <thead style="text-align:center;">
                <tr>
                    <th>Tanggal</th>
                    <th>Detail Kejadian</th>
                    <th>Nominal Kerugian</th>
                    <th>Status Masalah</th>
                    <th style="width: 30%">Aksi</th>
                </tr>
        </thead>
        </table>
        </div>
        </div>

        <hr>
        
        <div class="alert alert-light">
            <small> Pencarian spesifik berita acara bedasarkan periode dapat diakses melalui menu pencarian.</small>
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
            {data: 'tanggal', name: 'tanggal'},
            {data: 'detail_kejadian', name: 'detail_kejadian'},
            {data: 'nominal_kerugian', name: 'nominal_kerugian'},
            {data: 'status_masalah', name: 'status_masalah'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
    ]
    });

})

</script>

@endpush