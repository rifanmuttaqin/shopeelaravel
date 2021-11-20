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
            
            <form  method="post" action="{{route('produkpo-destroy')}}" enctype="multipart/form-data">

            @csrf

            <input type="hidden" value="{{ $data_produk->id }}" name="id">

            <div class="form-group">
                  <label>Nama Produk</label>
                  <input disabled type="text"  class="form-control form-control-user" name ="nama_produk" id="nama_produk" value="{{ $data_produk->nama_produk }}">
                  @if ($errors->has('nama_produk'))
                        <div><p style="color: red"><span>&#42;</span> {{ $errors->first('nama_produk') }}</p></div>
                  @endif
            </div>

            <div class="form-group">
                  <label>Harga</label>
                  <input disabled type="text"  class="form-control" name ="harga" id="harga" value="{{ $data_produk->harga }}">
                  @if ($errors->has('harga'))
                        <div><p style="color: red"><span>&#42;</span> {{ $errors->first('harga') }}</p></div>
                  @endif
            </div>

            <p>
                  <h5 style="font-family: 'Times New Roman', Times, serif; color: red"> anda yakin untuk menghapus data ini ? data yg telah dihapus tidak dapat untuk dikembalikan. </h5>
            </p>

            <div class="form-group" style="padding-top: 20px">
                  <a class="btn btn-warning" href="{{ route('produkpo') }}">Kembali</a>
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

<script type="text/javascript"></script>

@endpush