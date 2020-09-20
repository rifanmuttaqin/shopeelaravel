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


    <form method="post" action="{{ route('do-cetak-label') }}">
    @csrf

    <div class="form-group row">
    <div class="col-sm-12">
        <label><small>Periode Transaki</small></label>
        <input type="text" class="form-control" name="dates" id="dates">
        </div>
    </div>

    <div class="form-group">
        <label for="sel1">Status Cetak</label>
        <select class="form-control" id="type_cetak" name="type_cetak">
        <option value="BELUM">BELUM DI CETAK</option> 
        <option value="SEMUA">SEMUA</option>                   
        </select>
    </div>

    <div class="form-group">
        <button type="button" class="btn btn-info"> Tampilkan List </button>
        <button type="submit" class="btn btn-info"> Cetak </button>
    </div>

    </form>
     
</div>
</div>

@endsection

@push('scripts')

<script type="text/javascript">

$( document ).ready(function() {
    
    $('input[name="dates"]').daterangepicker();

});

</script>

@endpush