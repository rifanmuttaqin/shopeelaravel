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

    <div class="form-group row">
    <div class="col-sm-12">
      <label><small>Periode Transaki (Pilih periode tanggal)</small></label>
        <input type="text" class="form-control" name="dates" id="dates">
      </div>
    </div>

    <div style="padding-bottom: 20px">
        <button id="preview" type="button" class="btn btn-info"> <i class="fas fa-search"></i> Proses </button>
    </div>

    <hr>

    <div id='result_data'></div>
           
    </div>
    </div>
</div>
</div>


@endsection

@push('scripts')

<script type="text/javascript">

function cb(start, end) {
    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
}

$(function() {
    
    var start = moment().subtract(29, 'days');
    var end = moment();

    $('input[name="dates"]').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);


    $('#preview').click(function() {
        
        $('#result_data').html(null);

        $.ajax({
            url: '{{ route("laba-rugi-preview")}}',
            data:
            {
                "_token": "{{ csrf_token() }}",
                dates : $('#dates').val(),
            },                       
            type: 'post',
            beforeSend: function(){
                swal('Mohon tunggu sebentar data kami proses .......', { button:false, closeOnClickOutside:false});
            },
            success: function(data){
                $('#result_data').html(data);
            },
            complete: function(){
                swal.close();
            }
      });
    
    });


});


</script>

@endpush