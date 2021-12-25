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
                  
        <div class="form-group">
            <label>supplier</label>
            <input type="text" disabled class="form-control form-control-user" value="{{ $main_transaksi->supplier_name }}">
        </div>

        <table class="table">
            <thead>
              <tr>
                <th scope="col">Nama Produk</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Harga</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($transkasi_detail as $data)
                <tr>
                    <td>{{ $data->nama_produk}}</td>
                    <td>{{ $data->qty_beli}}</td>
                    <td>{{ $data->harga_produk}}</td>
                  </tr>
                @endforeach
            </tbody>
          </table>

        <div class="form-row">
            <div class="form-group col-md-2">
                <label>Diskon didapat</label>
                <input type="text" disabled class="form-control form-control-user" value="{{ $main_transaksi->discount_amount }}">
            </div>
            <div class="form-group col-md-8">
                <label>Total Belanja</label>
                <input type="text" disabled class="form-control form-control-user" value="{{ $main_transaksi->total_amount }}">
            </div>
        </div>

		@php
			if($main_transaksi->nota != null)
			{
				
				if(file_exists(public_path('storage'.'\\'.$main_transaksi->nota))) { 
					$main_image = URL::to('/').'/storage'.'/'.$main_transaksi->nota;
				}
				else {
					$main_image = URL::to('/layout/assets/img/no_logo.png');
				}		
			}
			else {
				$main_image = URL::to('/layout/assets/img/no_logo.png');
			}
		@endphp


        <div class="form-group">
          <label>NOTA</label>
          <img src="{{ $main_image }}" style="width:auto;height:auto; max-width: 300px;" class="img-thumbnail center-cropped form-control form-control-user">
        </div>

        <p>
            <h5 style="font-family: 'Times New Roman', Times, serif; color: red"> anda yakin untuk menghapus data ini ? data yg telah dihapus tidak dapat untuk dikembalikan. </h5>
        </p>

        <form  method="post" action="{{route('transaksi-po-destroy')}}" enctype="multipart/form-data">
            
        @csrf

        <input type="hidden" value="{{ $main_transaksi->id}}" name="id">

        <div class="form-group" style="padding-top: 20px">
            <a class="btn btn-warning" href="{{ route('transaksi-po-list') }}">Kembali</a>
            <button type="submit" class="btn btn-danger"> Delete </button>
        </div>

        </form>
            
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


})

</script>

@endpush