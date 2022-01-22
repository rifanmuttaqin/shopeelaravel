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

            <div style="width: 100%; padding-left: -10px;">
            <div class="table-responsive">
            <table id="table_result" class="table table-bordered data-table display nowrap" style="width:100%">
            <thead style="text-align:center;">
                  <tr>
                        <th>Nomor Invoice</th>
                        <th>Pelanggan</th>
                        <th>Tanggal Belanja / Dibuat</th>
                        <th>Total Belanja</th>
                        <th>STATUS</th>
                        <th style="width: 20%;">Rincian</th>
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

function changeStatus(param)
{
    //pop up
    swal({
            title: "Apkah kamu yakin ??",
            text: 'Status akan dirubah ke lunas', 
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            
            $.ajax({
                url: '{{ route("transaksi-offline-change-status")}}',
                data: {"_token": "{{ csrf_token() }}",param:param},                         
                type: 'post',
                beforeSend: function(){
                    swal('Status akan dirubah ke lunas .......', { button:false, closeOnClickOutside:false});
                },
                success: function(data){
                    // reload table
                    table.ajax.reload();
                },
                complete: function(){
                    swal.close();
                }
            });
          } else {
                swal("Status transaksi masih tetap");
            }
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
                {data: 'invoice_code', name: 'invoice_code'},
                {data: 'nama_customer', name: 'nama_customer'},
                {data: 'created_at', name: 'created_at'},
                {data: 'total_amount', name: 'total_amount'},
                {data: 'status_transaksi', name: 'status_transaksi'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
      });

    
})

</script>

@endpush