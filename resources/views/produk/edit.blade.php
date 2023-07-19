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
                <div class="row">
                    <div class="col-sm">
                        <div style="text-align: center; padding-top: 20px">
				      <img src="<?= URL::to('/layout/assets/img/no_image.png') ?>" style="width:200px;height:200px;" class="img-thumbnail center-cropped" id="product_pic">
			      </div>
                    </div>
                    <div class="col-8">
                        
                    <form style="padding-top:10px" method="POST" action="{{route('produk-update',$produk)}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                  
                    <div class="form-group">
                        <label>Nama Produk</label>
                        <input type="text" class="form-control form-control-user" name ="nama_produk" value="{{ $produk->nama_produk }}" id="nama_produk" placeholder="">
                        <small> Isi dengan nama produk </small>
                        @if ($errors->has('nama_produk'))
                              <div><p style="color: red"><span>&#42;</span> {{ $errors->first('nama_produk') }}</p></div>
                        @endif
                  </div>

                  <div class="form-group">
                        <label>SKU Produk</label>
                        <input type="text" class="form-control form-control-user" value="{{ $produk->sku_induk }}" name ="sku_induk" id="sku_induk" placeholder="">
                        <small> Isi dengan SKU / Kosongkan </small>
                        @if ($errors->has('sku_induk'))
                              <div><p style="color: red"><span>&#42;</span> {{ $errors->first('sku_induk') }}</p></div>
                        @endif
                  </div>
                
                    <div class="form-group">
                        <label>Harga Beli</label>
                        <input type="text" class="form-control" name ="harga_po" value="{{ $produk->harga_po }}" id="harga_po" placeholder="">
                        <small> Isi dengan beli produk </small>
                        @if ($errors->has('harga_po'))
                              <div><p style="color: red"><span>&#42;</span> {{ $errors->first('harga_po') }}</p></div>
                        @endif
                    </div>

                  <div class="form-group">
                        <label>Harga Jual</label>
                        <input type="text" class="form-control" value="{{ $produk->harga }}" name="harga" id="harga" placeholder="">
                        <small> Isi dengan harga produk </small>
                        @if ($errors->has('harga'))
                              <div><p style="color: red"><span>&#42;</span> {{ $errors->first('harga') }}</p></div>
                        @endif
                  </div>

                  <div class="form-group">
                        <input id='is_grosir' name="is_grosir" type="checkbox">
                        <label for="is_grosir"> Tentukan Grosir </label>
                  </div>

                  <div id="grosir_area">

                        <div class="form-row">

                        <div class="form-group col-md-6">
                              <label>Harga Grosir 1</label>
                              <input type="text" class="form-control" value="{{ $produk->harga_grosir_satu }}" name="harga_grosir_satu" id="harga_grosir_satu" placeholder="">
                              <small> Isi dengan harga grosir satu </small>
                              @if ($errors->has('harga_grosir_satu'))
                                    <div><p style="color: red"><span>&#42;</span> {{ $errors->first('harga_grosir_satu') }}</p></div>
                              @endif
                        </div>

                        <div class="form-group col-md-6">
                              <label>Minimal Pengambilan 1</label>
                              <input type="text" class="form-control" value="{{ $produk->minimal_pengambilan_satu }}" name ="minimal_pengambilan_satu" id="minimal_pengambilan_satu" placeholder="">
                              <small> Minimal pengambilan 1 </small>
                              @if ($errors->has('minimal_pengambilan_satu'))
                                    <div><p style="color: red"><span>&#42;</span> {{ $errors->first('minimal_pengambilan_satu') }}</p></div>
                              @endif
                        </div>

                        </div>

                        <div class="form-row">

                        <div class="form-group col-md-6">
                              <label>Harga Grosir 2</label>
                              <input type="text" class="form-control" value="{{ $produk->harga_grosir_dua }}"  name ="harga_grosir_dua" id="harga_grosir_dua" placeholder="">
                              <small> Isi dengan harga grosir dua </small>
                              @if ($errors->has('harga_grosir_dua'))
                                    <div><p style="color: red"><span>&#42;</span> {{ $errors->first('harga_grosir_dua') }}</p></div>
                              @endif
                        </div>

                        <div class="form-group col-md-6">
                              <label>Minimal Pengambilan 2</label>
                              <input type="text" class="form-control" value="{{ $produk->minimal_pengambilan_dua }}" name ="minimal_pengambilan_dua" id="minimal_pengambilan_dua" placeholder="">
                              <small> Minimal pengambilan 2 </small>
                              @if ($errors->has('minimal_pengambilan_dua'))
                                    <div><p style="color: red"><span>&#42;</span> {{ $errors->first('minimal_pengambilan_dua') }}</p></div>
                              @endif
                        </div>

                        </div>

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
                        <button type="submit" class="btn btn-info"> UBAH </button>
                        <a href="{{ URL::previous() }}" type="button" class="btn btn-danger"> BATAL </a>
                  </div>


            </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')

<script type="text/javascript">

$(function () { 

const is_grosir = '{{ $produk->is_grosir }}';

    if(is_grosir === '1')
    {
        $('#is_grosir').prop('checked', true);
        $('#grosir_area').show();
    }
    else
    {
        $('#is_grosir').prop('checked', false);
        $('#grosir_area').hide();
    }

    $('#is_grosir').change(function() {
        
        if(this.checked) {
            $('#grosir_area').show();
        }
        else {
            $('#grosir_area').hide();
        }

    });

})


</script>

@endpush