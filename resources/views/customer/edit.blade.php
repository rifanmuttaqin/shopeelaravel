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
        
        <form  method="post" action="#" enctype="multipart/form-data">

        @csrf

        <div style="margin:0 auto;text-align:center">
            <p> Import laporan penjualan | Fungsi ini akan melakukan scraping data cutomer dari file Excel</p>
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
            <button id="proses" type="button" class="btn btn-info"> IMPORT </button>
            <a href="{{route('index-customer')}}" id="back" type="button" class="btn btn-danger"> KEMBALI </a>
        </div>

        </form>
        
        <hr>

        <div id="result_data"> </div>

    </div>
    </div>
</div>
</div>

@endsection

@push('scripts')

<script type="text/javascript">

$('#proses').on('click', function() {
      var file_data = $('#file').prop('files')[0];   
      var form_data = new FormData();                  
      form_data.append('file', file_data);
      form_data.append('_token', "{{ csrf_token() }}");

      $.ajax({
            url: '{{ route("customer-update")}}',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'post',
            beforeSend: function(){
                  swal('Mohon tunggu sebentar prosess import dilakukan .......', { button:false, closeOnClickOutside:false});
            },
            success: function(data){
                  $('#result_data').html(data);
            },
            complete: function(){
                  swal.close();
            }
      });
});

$('#file').change(function() {
    var filename = $('#file').val();
    $('#filename').html(filename);
})

</script>

@endpush