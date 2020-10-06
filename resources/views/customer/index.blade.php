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

@section('modal')


<div class="modal fade" id="waModal" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
        <div class="modal-body">
     
          <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control" disabled id="username">
          </div>

          <div class="form-group">
            <label>Nomor</label>
            <input type="text" class="form-control" disabled value="" id="nomor">
          </div>

          <div class="form-group">
            <label>Isi Pesan Singkat</label>
            <textarea type="text" class="form-control" value="" id="pesan"> </textarea>
          </div>

          <div class="form-group">
            <small> * Pastikan anda telah login menggunakan whatshapp pada Komputer ini </small>
          </div>

        </div>
      
        <div class="modal-footer">
          <div class="form-group">
            <button type="button" id="kirim_pesan" class="btn btn-info btn-default pull-left">Kirim Pesan WA</button>
          </div>
        </div>       

    </div>
  </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">

$(function () {

  // Datatables
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

  // Row Click event
  $('.dataTable').on('click', 'tbody tr', function() {
      
      var data = table.row(this).data();

      $('#username').val(data.username_pembeli);
      $('#nomor').val(data.telfon_pembeli);
      $('#pesan').val(null);


      $('#waModal').modal('toggle');
  })


  // Kirim Pesan

  $( "#kirim_pesan" ).click(function() {

    var pesan = $('#pesan').val();
    var nomor = $('#nomor').val();

    var url   = "https://wa.me/:nomor?text=:pesan";
    url       = url.replace(':nomor', nomor);
    url       = url.replace(':pesan', pesan);

    window.open(url);


  });

});

</script>

@endpush