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
			<label><small>Periode Transaki (Kosongkan Untuk Keseluruhan Tanggal)</small></label>
			<input type="text" class="form-control" name="dates" id="dates">
		</div>
    </div>

    <div class="form-group">
		<label for="sel1">Status Cetak</label>
		<select class="form-control" id="type_cetak" name="type_cetak">
		<option value="SEMUA">Semua</option> 
		<option value="BELUM">Belum</option>
		<option value="SUDAH">Sudah</option>                                      
		</select>
    </div>

	<div class="form-group">
	<label>Nomer Resi</label>
		<select style="width: 100%" class="form-control form-control-user select2-class" name="transaksi_id" id="transaksi_id">
		</select>
	</div>

    <div class="form-group">
    	<label>Customer</label>
		<select style="width: 100%" class="form-control form-control-user select2-class" multiple="multiple" name="customer[]" id="customer">
		</select>
    </div>

    <div style="padding-bottom: 20px">
      	<button id="preview" type="button" class="btn btn-info"> <i class="fas fa-search"></i> LIHAT </button>
    </div>

    <div id="table_result"> 

    <hr>
      	<h3><div id="result_income"></div> </h3>
    <hr>

    <div id="table_result"> 
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
				<th style="width: 10%">Pendapatan Bersih</th>
				<th style="width: 10%">Tanggal Memesan</th>
				<th style="width: 10%">Catatan</th>
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
			<div class="form-group">
				<label>Username</label>
				<input type="text" class="form-control" disabled id="username">
			</div>

			<input type="hidden" class="form-control" id="transaksi_id_modal">

			<div class="form-group">
				<label>Detail Produk yang dipesan</label>
				<textarea type="text" class="form-control" disabled id="pesanan"> </textarea>
			</div>

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

var table;

function setResultIncome(param)
{
    var url_post = '{{route("income-get")}}';
    
    $.ajax({
		type:'POST',
		url: url_post,
		data: param,
		success:function(data) 
		{
			if(data.status)
			{
				document.getElementById("result_income").textContent = JSON.stringify('Penghasilan : ' + data.data);
			}
		}
    });
}


$(function () {

  $('#dates').val(null);
  $('#table_result').hide();
  $('#addCatatan').click(function() {

    $.ajax({
        type:'POST',
        url: '{{route("transaksi-update")}}',
        data:
        {
			"_token": "{{ csrf_token() }}",
			id : $('#transaksi_id_modal').val(),
			catatan_order : $('#catatan').val(),
        },
        success:function(data) {
          table.ajax.reload();
          $("#ModalProduk").modal('hide');
        }
    });

  });

  $('#preview').click(function() {

    var customer = $('#customer').val();

    var param = 
    {
        dates      : $('#dates').val(),
        type_cetak : $('#type_cetak').val(),
        customer   : customer,
		transaksi_id : $('#transaksi_id').val(),
        "_token"   : "{{ csrf_token() }}",
    };

    setResultIncome(param);

    table = $('.data-table').DataTable({
    
        ajax: 
        {
            "url": '{{route("preview-cetak")}}',
            "type": "POST",
            data: param,
            dataSrc: function ( json ) 
            {
              $('#table_result').show();
              return json.data;
            }     
        },

        destroy: true,
        responsive: true,
        searching: false,
        serverSide: true,
        columns: [
            {data: 'status_cetak', name: 'status_cetak'},
            {data: 'no_resi', name: 'no_resi'},
            {data: 'username_pembeli', name: 'username_pembeli'},
            {data: 'nama_pembeli', name: 'nama_pembeli'},
            {data: 'produk', name: 'produk'},
            {data: 'pendapatan_bersih', name: 'pendapatan_bersih'},
            {data: 'tgl_pesanan_dibuat', name: 'tgl_pesanan_dibuat'},
            {data: 'catatan_order', name: 'catatan_order'},
        ],

        columnDefs:[
            {
                "targets": [ 4 ],
                "visible": false,
                "searchable": false
            }
        ]
    });

  });


  // Row Click event
  $('#transaksi_table').on('click', 'tbody tr', function() {
		var data = table.row(this).data();
		$('#username').val(data.username_pembeli);
		$('#pesanan').val(data.produk);
		$('#transaksi_id_modal').val(data.id);
		$('#catatan').val(data.catatan_order);
		$('#ModalProduk').modal('toggle');
  })

  $('input[name="dates"]').daterangepicker({
		autoUpdateInput: true,
		locale: { cancelLabel: 'Bersihkan' }  
  });

  $('input[name="dates"]').on('cancel.daterangepicker', function(ev, picker) {
    	$('input[name="dates"]').val(null);
  });

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

	$('#transaksi_id').select2({
        allowClear: true,
		placeholder:'Nomer Resi',
        ajax: {
        url: '{{route("transaksi-list")}}',
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