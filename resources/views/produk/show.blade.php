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
                        
                    <form style="padding-top:10px">
                      
                    <div class="form-group">
                        <label>Nama Produk</label>
                        <input readonly type="text" class="form-control form-control-user" name ="nama_produk" value="{{ $produk->nama_produk }}" id="nama_produk" placeholder="">
                        <small> Isi dengan nama produk </small>
                  </div>

                  <div class="form-group">
                        <label>SKU Produk</label>
                        <input readonly type="text" class="form-control form-control-user" value="{{ $produk->sku_induk }}" name ="sku_induk" id="sku_induk" placeholder="">
                        <small> Isi dengan SKU / Kosongkan </small>
                  </div>
                
                    <div class="form-group">
                        <label>Harga Beli</label>
                        <input readonly type="text" class="form-control" name ="harga_po" value="{{ $produk->harga_po }}" id="harga_po" placeholder="">
                        <small> Isi dengan beli produk </small>
                    </div>

                  <div class="form-group">
                        <label>Harga Jual</label>
                        <input readonly type="text" class="form-control" value="{{ $produk->harga }}" name="harga" id="harga" placeholder="">
                        <small> Isi dengan harga produk </small>
                  </div>

                  <div id="grosir_area">

                        <div class="form-row">

                        <div class="form-group col-md-6">
                              <label>Harga Grosir 1</label>
                              <input readonly type="text" class="form-control" value="{{ $produk->harga_grosir_satu }}" name="harga_grosir_satu" id="harga_grosir_satu" placeholder="">
                              <small> Isi dengan harga grosir satu </small>
                              
                        </div>

                        <div class="form-group col-md-6">
                              <label>Minimal Pengambilan 1</label>
                              <input readonly type="text" class="form-control" value="{{ $produk->minimal_pengambilan_satu }}" name ="minimal_pengambilan_satu" id="minimal_pengambilan_satu" placeholder="">
                              <small> Minimal pengambilan 1 </small>
                              
                        </div>

                        </div>

                        <div class="form-row">

                        <div class="form-group col-md-6">
                              <label>Harga Grosir 2</label>
                              <input readonly type="text" class="form-control" value="{{ $produk->harga_grosir_dua }}"  name ="harga_grosir_dua" id="harga_grosir_dua" placeholder="">
                              <small> Isi dengan harga grosir dua </small>
                              
                        </div>

                        <div class="form-group col-md-6">
                              <label>Minimal Pengambilan 2</label>
                              <input readonly type="text" class="form-control" value="{{ $produk->minimal_pengambilan_dua }}" name ="minimal_pengambilan_dua" id="minimal_pengambilan_dua" placeholder="">
                              <small> Minimal pengambilan 2 </small>
                    
                        </div>

                        </div>

                  </div>

                  <div class="form-group" style="padding-top: 20px">
                        <a href="{{ URL::previous() }}" type="button" class="btn btn-danger"> KEMBALI </a>
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