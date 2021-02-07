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
        <p> Pada fitur ini, anda dapat mengakses riwayat pencetakan terakhir, dapat bermanfaat apabila anda perlu mencetak ulang label pengiriman.
    </div>
    </div>

    <div class="card">
    <div class="card-body">

        <div style="width: 100%; padding-left: -10px;">
            <div class="table-responsive">
                <table id="history_table" class="table table-bordered data-table display nowrap" style="width:100%">
                    <thead style="text-align:center;">
                        <tr>
                            <th>Filter Tanggal</th>
                            <th>Toko</th>
                            <th>Dicetak Pada</th>
                            <th style="width: 10%">Cetak Ulang</th>
                        </tr>
                    </thead>
                    <tbody>
                </tbody>
                </table>
            </div>
        </div>
        
        
    </div>
    </div>
</div>
</div>


@endsection
 

@push('scripts')

<script type="text/javascript">

function btnPrint(id)
{
    var url = '{{ route("do-cetak-history", ":id") }}';
    url     = url.replace(':id', id);
    window.location.replace(url);
}

$(function () {

    // Datatables
    table = $('#history_table').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true,
        ajax: "#",
        columns: [
            {data: 'date_range', name: 'date_range'},
            {data: 'user_toko_id', name: 'user_toko_id'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

});

</script>
 
 @endpush