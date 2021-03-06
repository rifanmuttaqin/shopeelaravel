<!-- Tambah dirubah dari submit ke AJAX -->

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
        
        <form  method="post" action="{{route('import-shopeepay')}}" enctype="multipart/form-data">

        @csrf

        <div style="margin:0 auto;text-align:center">
            <p> Import file xsl transaksi dari shopee center | cara mendapatkan file tersebut, akses shopee center pilih menu pada saldo saya</p>
            <p> File yang diimport akan mengupdate data transaksi, data transaksi yang terupdate akan memiliki harga, sehingga pada laporan anda akan mendapatkan total pendapatan bersih</p>
        </div>

        <!-- Upload Form  -->
        <div style="margin:0 auto;text-align:center">
            <div id="upload" style="">
                <input type="file" name="file" id="file" class="inputfile" accept="xls,xlsx"/>
                <label for="file"> &nbsp <i class="fas fa-file-upload"></i> Upload File &nbsp </label>
                <p id="filename"></p>
                <p> File Max. 2 MB </p>
            </div>
        </div>

        <div style="padding-bottom: 20px">
            <button id="proses" type="submit" class="btn btn-info"> IMPORT </button>
        </div>

        </form>	

    </div>
    </div>
</div>
</div>

@endsection

@push('scripts')

<script type="text/javascript">

$( "#proses" ).click(function() {
    swal('Mohon tunggu sebentar prosess import dilakukan .......', { button:false, closeOnClickOutside:false});
});

$('#file').change(function() {
    var filename = $('#file').val();
    $('#filename').html(filename);
})

</script>

@endpush