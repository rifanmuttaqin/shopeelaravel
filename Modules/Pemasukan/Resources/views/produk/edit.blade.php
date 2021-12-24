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

            <form  method="post" action="{{route('produk-update')}}" enctype="multipart/form-data">

                @csrf

                <input type="hidden" value="{{ $data_produk->id }}" name="id">

                <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text" class="form-control form-control-user" name ="nama_produk" id="nama_produk" value="{{ $data_produk->nama_produk }}">
                    <small> Isi dengan nama produk </small>
                    @if ($errors->has('nama_produk'))
                            <div><p style="color: red"><span>&#42;</span> {{ $errors->first('nama_produk') }}</p></div>
                    @endif
                </div>

                <div class="form-group">
                    <label>Harga</label>
                    <input type="text" class="form-control" name ="harga" id="harga" value="{{ $data_produk->harga }}">
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
                            <input type="text" class="form-control" value="{{ $data_produk->harga_grosir_satu }}" name ="harga_grosir_satu" id="harga_grosir_satu" placeholder="">
                            <small> Isi dengan harga grosir satu </small>
                            @if ($errors->has('harga_grosir_satu'))
                                <div><p style="color: red"><span>&#42;</span> {{ $errors->first('harga_grosir_satu') }}</p></div>
                            @endif
                    </div>

                    <div class="form-group col-md-6">
                            <label>Minimal Pengambilan 1</label>
                            <input type="text" class="form-control" value="{{ $data_produk->minimal_pengambilan_satu }}" name ="minimal_pengambilan_satu" id="minimal_pengambilan_satu" placeholder="">
                            <small> Minimal pengambilan 1 </small>
                            @if ($errors->has('minimal_pengambilan_satu'))
                                <div><p style="color: red"><span>&#42;</span> {{ $errors->first('minimal_pengambilan_satu') }}</p></div>
                            @endif
                    </div>

                    </div>

                    <div class="form-row">

                    <div class="form-group col-md-6">
                            <label>Harga Grosir 2</label>
                            <input type="text" class="form-control" value="{{ $data_produk->harga_grosir_dua }}" name ="harga_grosir_dua" id="harga_grosir_dua" placeholder="">
                            <small> Isi dengan harga grosir dua </small>
                            @if ($errors->has('harga_grosir_dua'))
                                <div><p style="color: red"><span>&#42;</span> {{ $errors->first('harga_grosir_dua') }}</p></div>
                            @endif
                    </div>

                    <div class="form-group col-md-6">
                            <label>Minimal Pengambilan 2</label>
                            <input type="text" class="form-control" value="{{ $data_produk->minimal_pengambilan_dua }}" name ="minimal_pengambilan_dua" id="minimal_pengambilan_dua" placeholder="">
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
                    <option value="0" @if($data_produk->status_aktif == 0) {{ 'selected' }} @endif>Tidak Aktif</option>
                </select>
                <small> Hanya data dengan status Aktif yang terpakai dalam program </small>
                @if ($errors->has('status_aktif'))
                    <div><p style="color: red"><span>&#42;</span> {{ $errors->first('status_aktif') }}</p></div>
                @endif
                </div>

                <div class="form-group" style="padding-top: 20px">
                    <a class="btn btn-warning" href="{{ route('produk') }}">Kembali</a>
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

$(function () { 

    const is_grosir = '{{ $data_produk->is_grosir }}';

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