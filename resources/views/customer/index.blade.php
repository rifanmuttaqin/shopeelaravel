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
				<small> Daftar pelanggan shopee & hanya khusus shopee, untuk pelanggan offline anda perlu mengakses ke menu modul pemasukan.</small>
				<small> Pelanggan yg baru diinput by sistem, umumnya belum mempunyai informasi lengkap terkait data, anda perlu melkukan renew data pelanggan secara berkala</small>
			</div> 

			<a class="btn btn-info"  href="{{ route('customer-edit') }}" role="button">
				Renew Data Pelanggan
			</a>

			<div style="width: 100%; padding-left: -10px; padding-top: 20px">
			<div class="table-responsive">
			<table id="customer_table" class="table table-bordered data-table display nowrap" style="width:100%">
			<thead style="text-align:center;">
						<tr>
									<th>Username Shopee</th>
									<th>Nama</th>
									<th style="width: 30%">Telfon</th>
									<th style="width: 10%">Alamat</th>
									<th>Frekuensi Order</th>
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
						<textarea style="height:150px" type="text" class="form-control" value="" id="pesan"> </textarea>
					</div>

					<div class="form-group">
						<small> * Pastikan anda telah login menggunakan whatshapp pada Komputer ini </small>
					</div>

				</div>
			
				<div class="modal-footer">
					<div class="form-group">
						<button type="button" id="detail_order" class="btn btn-info btn-default pull-right">Detail Order</button>
						<button type="button" id="kirim_pesan" class="btn btn-info btn-default pull-left">Kirim Pesan WA</button>
					</div>
				</div>       

		</div>
	</div>
</div>


<div class="modal fade" id="detailModal" role="dialog">
<div class="modal-dialog modal-xl">
			<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			
			<div class="modal-body">

						<div class="form-group">
									<label>Username</label>
									<input type="text" class="form-control" disabled id="username_pembeli">
						</div>

						<div class="table-responsive">
						<table id="order_table" class="table table-bordered data-table display nowrap" style="width:100%">
						<thead style="text-align:center;">
									<tr>
												<th>Nomor Resi</th>
												<th>Nama</th>
												<th>Alamat Pesanan</th>
												<th>Hp Penerima</th>
												<th>Produk</th>
												<th>Tanggal Memesan</th>
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
	$('#customer_table').on('click', 'tbody tr', function() {
			
			var data = table.row(this).data();

			$('#username').val(data.username_pembeli);
			$('#nomor').val(data.telfon_pembeli);
			$('#pesan').val(null);

			// Detail Order Modal
			$('#username_pembeli').val(data.username_pembeli);

			var param = { id_customer : data.id, "_token": "{{ csrf_token() }}"};

			table_order = $('#order_table').DataTable({
						
						ajax: 
						{
									"url": '{{route("customer-order")}}',
									"type": "POST",
									data: param,
									dataSrc: function ( json ) 
									{
												return json.data;
									}     
						},

						scrollY: "200px",
						destroy: true,
						responsive: true,
						searching: true,
						order:false,
						serverSide: true,
						columns: [
									{data: 'no_resi', name: 'no_resi'},
									{data: 'nama_pembeli', name: 'nama_pembeli'},
									{data: 'alamat_pembeli', name: 'alamat_pembeli'},
									{data: 'telfon_pembeli', name: 'telfon_pembeli'},
									{data: 'produk', name: 'produk'},
									{data: 'tgl_pesanan_dibuat', name: 'tgl_pesanan_dibuat'},
						],

			});

			$('#waModal').modal('toggle');
	})


	$('#detail_order').click(function(){

			$('#waModal').modal('hide');
			$('#detailModal').modal('toggle');
	
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