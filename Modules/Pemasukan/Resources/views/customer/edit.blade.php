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

            <form  method="post" action="{{route('customer-offline-update')}}" enctype="multipart/form-data">

                @csrf

                <input type="hidden" value="{{ $data_customer->id }}" name="id">

                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control form-control-user" name ="nama" id="nama" value="{{ $data_customer->nama }}">
                    <small> Isi nama pelanggan </small>
                    @if ($errors->has('nama'))
                            <div><p style="color: red"><span>&#42;</span> {{ $errors->first('nama') }}</p></div>
                    @endif
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" class="form-control form-control-user" name ="alamat" id="alamat" value="{{ $data_customer->alamat }}">
                    <small> Isi alamat pelanggan </small>
                    @if ($errors->has('nama'))
                            <div><p style="color: red"><span>&#42;</span> {{ $errors->first('alamat') }}</p></div>
                    @endif
                </div>

                <div class="form-group">
                        <label>Kontak</label>
                        <input type="text" class="form-control form-control-user" value="{{ $data_customer->no_hp }}" name ="no_hp" id="no_hp" placeholder="">
                        <small> Nomor HP </small>
                        @if ($errors->has('no_hp'))
                            <div><p style="color: red"><span>&#42;</span> {{ $errors->first('no_hp') }}</p></div>
                        @endif
                </div>

                <div class="form-group">
                        <label>Akun Shopee</label>
                        <input type="text" class="form-control form-control-user" value="{{ $data_customer->akun_shopee }}" name ="akun_shopee" id="akun_shopee" placeholder="">
                        <small> Nomor HP </small>
                        @if ($errors->has('akun_shopee'))
                            <div><p style="color: red"><span>&#42;</span> {{ $errors->first('akun_shopee') }}</p></div>
                        @endif
                </div>

    
                <div class="form-group">
                <label>Status Aktif</label>
                <select name="status_aktif" class="form-control">
                    <option value="1">Aktif</option>
                    <option value="0" @if($data_customer->status_aktif == 0) {{ 'selected' }} @endif>Tidak Aktif</option>
                </select>
                <small> Hanya data dengan status Aktif yang terpakai dalam program </small>
                @if ($errors->has('status_aktif'))
                    <div><p style="color: red"><span>&#42;</span> {{ $errors->first('status_aktif') }}</p></div>
                @endif
                </div>

                <div class="form-group" style="padding-top: 20px">
                    <a class="btn btn-warning" href="{{ route('customer-offline') }}">Kembali</a>
                    <button type="submit" class="btn btn-info"> Update </button>
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

$(function () { })

</script>

@endpush