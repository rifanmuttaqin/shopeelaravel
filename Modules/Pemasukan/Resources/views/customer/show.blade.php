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
                <label>Nama</label>
                <input type="text" disabled class="form-control form-control-user" name ="nama" id="nama" value="{{ $data_customer->nama }}">
                <small> Isi nama pelanggan </small>
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <input disabled type="text" class="form-control form-control-user" name ="alamat" id="alamat" value="{{ $data_customer->alamat }}">
                <small> Isi alamat pelanggan </small>
            </div>

            <div class="form-group">
                    <label>Kontak</label>
                    <input disabled type="text" class="form-control form-control-user" value="{{ $data_customer->no_hp }}" name ="no_hp" id="no_hp" placeholder="">
                    <small> Nomor HP </small>
            </div>

            <div class="form-group">
                    <label>Akun Shopee</label>
                    <input disabled type="text" class="form-control form-control-user" value="{{ $data_customer->akun_shopee }}" name ="akun_shopee" id="akun_shopee" placeholder="">
                    <small> Nomor HP </small>
            </div>


            <div class="form-group">
                <label>Status</label>
                <input @if(!$data_customer->status_aktif) style={{"background-color:#c89f9f"}} @endif disabled value="@if($data_customer->status_aktif) {{'AKTIF'}} @else {{'TIDAK AKTIF'}} @endif" type="text" class="form-control form-control-user" placeholder="">
            </div>

            <div class="form-group" style="padding-top: 20px">
                <a class="btn btn-warning" href="{{ route('customer-offline') }}">Kembali</a>
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