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

    <div class="alert alert-light">
        <i class="fas fa-info-circle"></i> &nbsp Masukkan nama pelanggan, nama akan di konversi menjadi lowcase saat ditampilkan.
    </div> 

    <form method="post" action="{{ route('do-cetak-offline') }}">
        
        @csrf

        <div class="form-group">
            <label>Nama Pelanggan</label>
            <input type="text" class="form-control" value="" name="nama_pelanggan">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-info" id="cetakData"> Cetak </button>
        </div>

    </form>
     
    </div>
</div>
</div>
</div>

@endsection


@push('scripts')

<script type="text/javascript">

$( document ).ready(function() { });

</script>

@endpush