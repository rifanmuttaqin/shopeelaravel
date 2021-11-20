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

            <form  method="post" action="{{route('supplier-store')}}" enctype="multipart/form-data">

                  @csrf
                  
                  <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control form-control-user" name ="nama" id="nama" placeholder="">
                        <small> Isi dengan nama </small>
                        @if ($errors->has('nama'))
                              <div><p style="color: red"><span>&#42;</span> {{ $errors->first('nama') }}</p></div>
                        @endif
                  </div>

                  <div class="form-group">
                        <label>Kontak</label>
                        <input type="text" class="form-control form-control-user" name ="kontak" id="kontak" placeholder="">
                        <small> Isi dengan nomor telfon supplier </small>
                        @if ($errors->has('kontak'))
                              <div><p style="color: red"><span>&#42;</span> {{ $errors->first('kontak') }}</p></div>
                        @endif
                  </div>

                  <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control form-control-user" name ="alamat" id="alamat" placeholder="">
                        <small> Isi dengan alamat </small>
                        @if ($errors->has('alamat'))
                              <div><p style="color: red"><span>&#42;</span> {{ $errors->first('alamat') }}</p></div>
                        @endif
                  </div>


                  <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" class="form-control form-control-user" name ="keterangan" id="keterangan" placeholder="">
                        <small> Kosongkan jika tidak diperlukan </small>
                        @if ($errors->has('keterangan'))
                              <div><p style="color: red"><span>&#42;</span> {{ $errors->first('keterangan') }}</p></div>
                        @endif
                  </div>

                  <div class="form-group">
                  <label>Status Aktif</label>
                  <select name="status_aktif" class="form-control">
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                  </select>
                  <small> Hanya data dengan status Aktif yang terpakai dalam program </small>
                  @if ($errors->has('status_aktif'))
                        <div><p style="color: red"><span>&#42;</span> {{ $errors->first('status_aktif') }}</p></div>
                  @endif
                  </div>

                  <div class="form-group" style="padding-top: 20px">
                        <button type="submit" class="btn btn-info"> Tambah </button>
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

<script type="text/javascript"></script>

@endpush