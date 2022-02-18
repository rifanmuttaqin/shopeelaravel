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

    <div class="alert alert-light">
        <i class="fas fa-bell"></i> &nbsp Klik <a href="{{ route('cetak-offline') }}"> disini </a> untuk membuat label ucapan secara manual dengan memasukkan nama pelanggan.
    </div> 

    <form method="post" action="{{ route('do-cetak-label') }}">
    @csrf

    <div class="form-group row">
    <div class="col-sm-12">
        <label><small>Periode Transaki</small></label>
        <input type="text" class="form-control" name="dates" id="dates">
        </div>
    </div>

    <div class="form-group">
        <label for="sel1">Status Cetak</label>
        <select class="form-control" id="type_cetak" name="type_cetak">
        <option value="BELUM">BELUM DI CETAK</option> 
        <option value="SEMUA">SEMUA</option>                   
        </select>
    </div>

    <div class="form-group">
    <label>Pilihan Toko (<small>kosongkan jika default</small>)</label>
      <select style="width: 100%" class="form-control form-control-user select2-class" name="toko" id="toko">
      </select>
    </div>

    <div class="form-group">
    <label>Customer</label>
      <select style="width: 100%" multiple="multiple" class="form-control form-control-user select2-class" name="customer[]" id="customer">
      </select>
    </div>

    <div class="form-group">
        <button type="button" class="btn btn-info" id="previewData"> Tampilkan List </button>
        <button type="submit" class="btn btn-info" id="cetakData"> Cetak </button>
    </div>

    </form>

    <div id="table_result">
        <small style="color: blue"> Klik Untuk Menambah Catatan </small>
        <hr>
        <table id="transaksi_table" class="table table-bordered data-table display nowrap" style="width:100%">
        <thead style="text-align:center;">
            <tr>
                <th>Nomor Resi</th>
                <th>Username</th>
                <th>Status Cetak</th>
                <th>Catatan</th>
            </tr>
        </thead>
        </table>
    </div>
     
</div>
</div>

@endsection

@section('modal')

<div class="modal fade" id="ModalProduk" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
        <div class="modal-body">
     
          <input type="hidden" class="form-control" id="transaksi_id">

          <div class="form-group">
            <label>Tambahkan Catatan</label>
            <textarea type="text" class="form-control" id="catatan"> </textarea>
          </div>

          <div style="padding-bottom: 20px">
            <button id="addCatatan" type="button" class="btn btn-info"> <i class="fas fa-plus"></i> Catatan </button>
          </div>

        </div>

    </div>
  </div>
</div>

@endsection


@push('scripts')

<script type="text/javascript">

function cb(start, end) {
    $('#dates span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
}


$( document ).ready(function() {

	var start = moment().subtract(29, 'days');
    var end = moment();

    // select2-class
    $('#toko').select2({
        allowClear: true,
        ajax: {
        url: '{{route("toko-list")}}',
        type: "POST",
        dataType: 'json',
            data: function(params) {
                return {
                  "_token": "{{ csrf_token() }}",
                  search: params.term,
                }
            },
            processResults: function (data, page) {
                return {
                results: data
                };
            }
        }
    })


    $('#table_result').hide();
    $('#cetakData').hide();

    var table;

    // Row Click event
    $('#transaksi_table').on('click', 'tbody tr', function() {
      var data = table.row(this).data();
      $('#transaksi_id').val(data.id);
      $('#catatan').val(data.catatan_order);
      $('#ModalProduk').modal('toggle');
    })

    $('#addCatatan').click(function() {

        $.ajax({
            type:'POST',
            url: '{{route("transaksi-update")}}',
            data:
            {
              "_token": "{{ csrf_token() }}",
              id : $('#transaksi_id').val(),
              catatan_order : $('#catatan').val(),
            },
            success:function(data) {

              table.ajax.reload();
              $("#ModalProduk").modal('hide');
              
            }
        });

    });
    
    $('input[name="dates"]').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

    $('#previewData').click(function() {
        
        var param = 
        {
            dates       : $('#dates').val(),
            type_cetak  : $('#type_cetak').val(),
            toko        : $('#toko').val(),
            customer    : $('#customer').val(),
            "_token": "{{ csrf_token() }}",
        };

        table = $('.data-table').DataTable({
        
            ajax: 
            {
                "url": '{{route("preview-cetak")}}',
                "type": "POST",
                data: param,
                dataSrc: function ( json ) 
                {
                    $('#table_result').show();
                    $('#cetakData').show();
                    return json.data;
                }     
            },

            destroy: true,
            responsive: true,
            searching: false,
            serverSide: true,
            columns: [
                {data: 'no_resi', name: 'no_resi'},
                {data: 'username_pembeli', name: 'username_pembeli'},
                {data: 'status_cetak', name: 'status_cetak'},
                {data: 'catatan_order', name: 'catatan_order'},
            ],

        });
    })

    $('#customer').select2({
        allowClear: true,
        ajax: {
        url: '{{route("list-customer")}}',
        type: "POST",
        dataType: 'json',
            data: function(params) {
                return {
                  "_token": "{{ csrf_token() }}",
                  search: params.term,
                }
            },
            processResults: function (data, page) {
                return {
                results: data
                };
            }
        }
    })

});

</script>

@endpush