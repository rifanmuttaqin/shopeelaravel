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
      <table id="customer_table" class="table table-bordered data-table display nowrap" style="width:100%">
      <thead style="text-align:center;">
          <tr>
              <th style="width: 10%">Username Shopee</th>
              <th style="width: 50%">Nama</th>
              <th style="width: 30%">Telfon</th>
              <th style="width: 10%">Alamat</th>
              <th style="width: 10%">Frekuensi Order</th>
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

$(function () {
  table = $('#customer_table').DataTable({
      processing: true,
      serverSide: true,
      rowReorder: {
          selector: 'td:nth-child(2)'
      },
      responsive: true,
      ajax: "{{ route('index-customer') }}",
      columns: [
          {data: 'username_pembeli', name: 'username_pembeli'},
          {data: 'nama_pembeli', name: 'nama_pembeli'},
          {data: 'telfon_pembeli', name: 'telfon_pembeli'},
          {data: 'alamat_pembeli', name: 'alamat_pembeli'},
          {data: 'sum_order', name: 'sum_order'},
      ]
  });
});

</script>

@endpush