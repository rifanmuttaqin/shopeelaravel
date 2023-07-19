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
                        <th style="width: 10%">Aksi</th>
                  </tr>
            </thead>
            </table>
            </div>
            </div> 
    </div>
</div>
</div>


@endsection

@push('scripts')

<script type="text/javascript">

let table;

function deleteAction(id)
{
    var itemId = id;

    // Tampilkan konfirmasi SweetAlert
    swal({
        title: 'Konfirmasi',
        text: 'Anda yakin ingin menghapus item ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((willDelete) => {     
        if(willDelete)
        {
            var url = "{{ route('produk-delete', ':id') }}";
            url = url.replace(':id', itemId);
            window.location.href = url;
        }   
        return false;
    });
}

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


    $('.delete-btn').on('click', function() {

        var itemId = $(this).data('id');
        
        // Tampilkan konfirmasi SweetAlert
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Anda yakin ingin menghapus item ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Arahkan pengguna ke URL langsung untuk menghapus item
                window.location.href = '';
            }
        });
    });



})

</script>

@endpush