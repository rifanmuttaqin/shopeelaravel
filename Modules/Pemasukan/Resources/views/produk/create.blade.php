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

            <form  method="post" action="{{route('produk-store')}}" enctype="multipart/form-data">

                  @csrf
                  
                  <div class="form-group">
                        <label>Nama Produk</label>
                        <input type="text" class="form-control form-control-user" name ="nama_produk" id="nama_produk" placeholder="">
                        <small> Isi dengan nama produk </small>
                        @if ($errors->has('nama_produk'))
                              <div><p style="color: red"><span>&#42;</span> {{ $errors->first('nama_produk') }}</p></div>
                        @endif
                  </div>

                  <div class="form-group">
                        <label>Harga</label>
                        <input type="text" class="form-control" name ="harga" id="harga" placeholder="">
                        <small> Isi dengan harga produk </small>
                        @if ($errors->has('harga'))
                              <div><p style="color: red"><span>&#42;</span> {{ $errors->first('harga') }}</p></div>
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

<script type="text/javascript">

$(function () {


})

</script>

@endpush