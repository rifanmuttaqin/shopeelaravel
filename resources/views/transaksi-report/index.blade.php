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

    <div class="form-group row">
    <div class="col-sm-12">
      <label><small>Periode Transaki</small></label>
      <input type="text" class="form-control" name="dates" id="dates">
      </div>
    </div>

    <div class="form-group">
            <label for="sel1">Status Cetak</label>
            <select class="form-control" id="account_type" name="account_type">
            <option value="Belum">Belum</option>
            <option value="Belum">Sudah</option>                                      
            </select>
    </div>

    <div style="padding-bottom: 20px">
      <button id="proses" type="button" class="btn btn-info"> <i class="fas fa-print"></i> CETAK </button>
    </div>


    <hr>


    <div style="width: 100%; padding-left: -10px;">
      <div class="table-responsive">
      <table id="transaksi_table" class="table table-bordered data-table display nowrap" style="width:100%">
      <thead style="text-align:center;">
          <tr>
              <th style="width: 10%">Status Cetak</th>
              <th style="width: 10%">Nomor Resi</th>
              <th style="width: 50%">User Name Shopee</th>
              <th style="width: 30%">Nama</th>
              <th style="width: 10%">Produk</th>
              <th style="width: 10%">Tanggal Memesan</th>
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
  table = $('#transaksi_table').DataTable({
      processing: true,
      serverSide: true,
      rowReorder: {
          selector: 'td:nth-child(2)'
      },
      responsive: true,
      ajax: "{{ route('report-transaksi') }}",
      columns: [
          {data: 'status_cetak', name: 'status_cetak'},
          {data: 'no_resi', name: 'no_resi'},
          {data: 'username_pembeli', name: 'username_pembeli'},
          {data: 'nama_pembeli', name: 'nama_pembeli'},
          {data: 'produk', name: 'produk'},
          {data: 'tgl_pesanan_dibuat', name: 'tgl_pesanan_dibuat'},
      ]
  });

  $('input[name="dates"]').daterangepicker({
    locale: { cancelLabel: 'Bersihkan' }  
  });

  $('input[name="dates"]').on('cancel.daterangepicker', function(ev, picker) {
      $('input[name="dates"]').val(null);
  });

});

</script>

@endpush