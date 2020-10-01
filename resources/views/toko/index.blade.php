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
      <a  href="{{ route('toko-create') }}" type="button" class="btn btn-info"> TAMBAH </a>
    </div>

    <div style="width: 100%; padding-left: -10px;">
      <div class="table-responsive">
      <table id="toko_table" class="table table-bordered data-table display nowrap" style="width:100%">
      <thead style="text-align:center;">
          <tr>
              <th style="width: 10%">Nama Toko</th>
              <th style="width: 50%">Alamat</th>
              <th style="width: 30%">Aksi</th>
          </tr>
      </thead>
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

function btnUbah(id)
{
  var url = '{{ route("toko-edit", ":id") }}';
  url     = url.replace(':id', id);
  window.location.replace(url);
}


$(function () {
  table = $('#toko_table').DataTable({
      processing: true,
      serverSide: true,
      rowReorder: {
          selector: 'td:nth-child(2)'
      },
      responsive: true,
      ajax: "#",
      columns: [
        {data: 'nama_toko', name: 'nama_toko'},
        {data: 'alamat_toko', name: 'alamat_toko'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
      ]
  });
});

</script>

@endpush