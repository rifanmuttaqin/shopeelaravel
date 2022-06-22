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
				<small> Daftar ekspedisi Shopee ini dapat dibuat otomatis oleh sistem ketika proses import transaksi dilakukan.</small>
			</div> 
            			
			<div style="width: 100%; padding-left: -10px; padding-top: 20px">
			<div class="table-responsive">
			<table id="ekspedisi_table" class="table table-bordered data-table display nowrap" style="width:100%">
			<thead style="text-align:center;">
						<tr>
							<th>Nama Ekspedisi</th>
							<th>Kode Ekspedisi</th>
							<th style="width: 30%">Kurir</th>
							<th style="width: 10%">Nomor Kurir</th>
							<th>Alamat Droppoint</th>
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


@endsection


@push('scripts')

<script type="text/javascript">

$(function () {

	// Datatables
	table = $('#ekspedisi_table').DataTable({
			processing: true,
			serverSide: true,
			rowReorder: {
					selector: 'td:nth-child(2)'
			},
			responsive: true,
			ajax: "{{ route('index-ekspedisi') }}",
			columns: [
                {data: 'ekspedisi_name', name: 'ekspedisi_name'},
                {data: 'ekspedisi_kode', name: 'ekspedisi_kode'},
                {data: 'ekspedisi_kurir_pickup', name: 'ekspedisi_kurir_pickup'},
                {data: 'ekspedisi_kurir_number', name: 'ekspedisi_kurir_number'},
                {data: 'ekspedisi_droppoint_address', name: 'ekspedisi_droppoint_address'},
			]
	});

});

</script>

@endpush