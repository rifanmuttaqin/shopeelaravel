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
                  <label>Nama Produk</label>
                  <input type="text" disabled class="form-control form-control-user" name ="nama_produk" id="nama_produk" value="{{ $data_produk->nama_produk }}">
                  @if ($errors->has('nama_produk'))
                        <div><p style="color: red"><span>&#42;</span> {{ $errors->first('nama_produk') }}</p></div>
                  @endif
            </div>

            <div class="form-group">
                <label>SKU Induk</label>
                <input type="text" disabled class="form-control form-control-user" name ="sku_induk" id="sku_induk" value="{{ $data_produk->sku_induk }}">
            </div>

            <div class="form-group">
                  <label>Harga Utama</label>
                  <input type="text" disabled class="form-control" name ="harga" id="harga" value="{{ $data_produk->harga }}">
                  @if ($errors->has('harga'))
                        <div><p style="color: red"><span>&#42;</span> {{ $errors->first('harga') }}</p></div>
                  @endif
            </div>

            @if($data_produk->is_grosir)

            <div id="grosir_area">

                <div class="form-row">

                <div class="form-group col-md-6">
                      <label>Harga Grosir 1</label>
                      <input type="text" class="form-control" disabled name ="harga_grosir_satu" value="{{ $data_produk->harga_grosir_satu }}" id="harga_grosir_satu" placeholder="">
                </div>

                <div class="form-group col-md-6">
                      <label>Minimal Pengambilan 1</label>
                      <input type="text" class="form-control" disabled name ="minimal_pengambilan_satu" value="{{ $data_produk->minimal_pengambilan_satu }}" id="minimal_pengambilan_satu" placeholder="">
                </div>

                </div>

                <div class="form-row">

                <div class="form-group col-md-6">
                      <label>Harga Grosir 2</label>
                      <input type="text" disabled class="form-control" value="{{ $data_produk->harga_grosir_dua }}" name ="harga_grosir_dua" id="harga_grosir_dua" placeholder="">
                </div>

                <div class="form-group col-md-6">
                      <label>Minimal Pengambilan 2</label>
                      <input type="text" disabled class="form-control" value="{{ $data_produk->minimal_pengambilan_dua }}" name ="minimal_pengambilan_dua" id="minimal_pengambilan_dua" placeholder="">
                </div>

                </div>

            </div>

            @endif


            <div class="form-group">
                  <label>Status</label>
                  <input @if(!$data_produk->status_aktif) style={{"background-color:#c89f9f"}} @endif disabled value="@if($data_produk->status_aktif) {{'AKTIF'}} @else {{'TIDAK AKTIF'}} @endif" type="text" class="form-control form-control-user" placeholder="">
            </div>

            <table class="table table-striped" style="width: 50%">
            <tbody>
                  <tr>
                        <td>Dibuat pada</td>
                        <td>{{ date_format($data_produk->created_at,"d F Y H:i:s") }}</td>
                  </tr>

                  <tr>
                        <td>Terakhir diupdate</td>
                        <td>{{ date_format($data_produk->updated_at,"d F Y H:i:s") }}</td>
                  </tr>
            </tbody>
            </table>

            <div class="form-group" style="padding-top: 20px">
                  <a class="btn btn-warning" href="{{ route('produk') }}">Kembali</a>
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


})

</script>

@endpush