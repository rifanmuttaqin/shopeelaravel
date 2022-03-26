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
                <label>Nama Pembeli</label>
                <input type="text" disabled class="form-control form-control-user" name ="nama_pembeli" id="nama_pembeli" value="{{ $data->nama_pembeli }}">
            </div>

            <div class="form-group">
                <label>Username Shopee</label>
                <input type="text" disabled class="form-control form-control-user" name ="username_pembeli" id="username_pembeli" value="{{ $data->username_pembeli }}">
            </div>

            <div class="form-group">
                <label>Nomor Resi</label>
                <input type="text" disabled class="form-control form-control-user" name ="no_resi" id="no_resi" value="{{ $data->no_resi }}">
            </div>

            <div class="form-group">
                <label>Nomor Pesanan Shopee</label>
                <input type="text" disabled class="form-control form-control-user" name ="no_pesanan" id="no_pesanan" value="{{ $data->no_pesanan }}">
            </div>

            <div class="form-group">
                <label>Tanggal Pesanan Dibuat</label>
                <input type="text" disabled class="form-control form-control-user" name ="tgl_pesanan_dibuat" id="tgl_pesanan_dibuat" value="{{ $data->tgl_pesanan_dibuat }}">
            </div>

            
            <div class="form-group">
                <label>Jasa Kirim</label>
                <input type="text" disabled class="form-control form-control-user" name ="jasa_kirim" id="jasa_kirim" value="{{ $data->jasa_kirim }}">
            </div>


            <div class="form-group">
                <label>Nomor Telfon</label>
                <input type="text" disabled class="form-control form-control-user" name ="telfon_pembeli" id="telfon_pembeli" value="{{ $data->telfon_pembeli }}">
            </div>

            
            <div class="form-group">
                <label>Alamat Pembeli</label>
                <textarea disabled rows="10" style="height:80%;" type="text" class="form-control form-control-user" name ="alamat_pembeli" id="alamat_pembeli"> {{ $data->alamat_pembeli }} </textarea>
            </div>

            <div class="form-group">
                <label>Produk</label>
                <textarea disabled rows="10" style="height:80%;" type="text" class="form-control form-control-user" name ="produk" id="produk"> {{ $data->produk }} </textarea>
            </div>

            <hr>

            <h4> Pendapatan dari transaksi ini : {{ $data->pendapatan_bersih }}</h4>
            
            <hr>

        
            <div class="form-group" style="padding-top: 20px">
                <a class="btn btn-warning" href="{{ route('listpage-transaksi') }}">Kembali</a>
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

$(function () { })

</script>

@endpush