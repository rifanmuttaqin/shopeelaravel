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
        
        <div style="margin:0 auto;text-align:center">
            <p> Export data customer ke dalam bentuk xslx</p>
        </div>

        <div class="form-group">
            <label><strong>PARAMETER (<small> mohon untuk mengisi parameter dibawah ini </small>)</strong></label>
        </div>

        <hr>

        <form  method="post" action="{{ route('customer-do-export') }}" enctype="multipart/form-data">

            @csrf

            <div class="form-group">
                <input type="checkbox" id="order_more_than_twice" name="order_more_than_twice">
                <label for="order_more_than_twice"> Pesan lebih dari 3x</label><br>
            </div>

            <div class="form-group">
                <input type="checkbox" id="first_time" name="first_time">
                <label for="first_time">Baru memesan 1x</label><br>
            </div>

            <div class="form-group">
                <input type="checkbox" id="not_include_undefined" name="not_include_undefined">
                <label for="not_include_undefined">Hanya yg mempunyai HP</label><br>
            </div>

            <div class="form-group">
                <label for="kabupaten_kota"> Kabupaten / Kota Tertentu </label>
                <input type="text" class="form-control" id="kabupaten_kota" name="kabupaten_kota">
            </div>

            <div class="form-group">
                <label for="provinsi"> Provinsi Tertentu </label>
                <input type="text" class="form-control" id="provinsi" name="provinsi">
            </div>
            
            <div style="padding-bottom: 20px">
                <button id="proses" type="submit" class="btn btn-info"> EXPORT </button>
                <a href="{{route('index-customer')}}" id="back" type="button" class="btn btn-danger"> KEMBALI </a>
            </div> 

        </form>

    </div>
    </div>
</div>
</div>

@endsection

@push('scripts')

<script type="text/javascript">

</script>

@endpush