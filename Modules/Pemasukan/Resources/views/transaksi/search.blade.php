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
        <label><small>Periode</small></label>
        <input type="text" class="form-control" name="dates" id="dates">
        </div>
    </div>

    <div class="form-group">
        <div class="form-group">
            <label>Customer</label>
            <select style="width: 100%" class="form-control form-control-user select2-class" name="nama_customer" id="nama_customer">
            </select>
            @if ($errors->has('nama_customer'))
                    <div><p style="color: red"><span>&#42;</span> {{ $errors->first('nama_customer') }}</p></div>
            @endif
        </div>
    </div>
    
    <div class="form-group">
        <div class="form-group">
            <label>Nomor Invoice</label>
            <select style="width: 100%" class="form-control form-control-user select2-class" name="invoice_code" id="invoice_code">
            </select>
        </div>
    </div>

    <div class="form-group" style="padding-top: 20px">
        <button id="tampil" class="btn btn-info">Tampil</button>
        <a class="btn btn-warning" href="{{ route('transaksi-po-list') }}">Kembali</a>
    </div>

    <div id="result"></div>

    </div>

    </div>
</div>
</div>

@endsection

@section('modal')


@endsection

@push('scripts')

<script type="text/javascript">

function changeStatus(param)
{
    //pop up
    swal({
            title: "Apkah kamu yakin ??",
            text: 'Status akan dirubah ke lunas', 
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            
            $.ajax({
                url: '{{ route("transaksi-offline-change-status")}}',
                data: {"_token": "{{ csrf_token() }}",param:param},                         
                type: 'post',
                beforeSend: function(){
                    swal('Status akan dirubah ke lunas .......', { button:false, closeOnClickOutside:false});
                },
                success: function(data){
                    // reload table
                    tampilPreview();
                },
                complete: function(){
                    swal.close();
                }
            });
          } else {
                swal("Status transaksi masih tetap");
            }
    });
}


function tampilPreview()
{
    let customer = $('#nama_customer').select2('data');

    customer = customer.length > 0 ? customer[0].text : null;
    
    $.ajax({
        type:'POST',
        url: '{{route("transaksi-offline-preview")}}',
        data:
        {
            "_token": "{{ csrf_token() }}",
            id : $('#transaksi_id').val(),
            dates : $('#dates').val(),
            invoice_code : $('#invoice_code').val(),
            nama_customer : customer,
        },
        success:function(data) {
            $('#result').html(data);
        }
    });
}

$(function () {

    $('#nama_customer').select2({
        allowClear: true,
        placeholder:'Pelanggan',
        ajax: {
            url: '{{ route("customer-offline-list") }}',
            type: "POST",
            dataType: 'json',
            data: function(params) {
                return {
                "_token": "{{ csrf_token() }}",
                search: params.term,
                }
            },
            processResults: function (data, page) {
                return {
                results: data
                };
            }
        }
    })

    $('input[name="dates"]').daterangepicker();

    $( "#tampil" ).click(function() {
        tampilPreview();
    });

    $('#invoice_code').select2({
        allowClear: true,
        placeholder:'Kode Invoice',
        ajax: {
            url: '{{ route("transaksi-offline-list-invoice") }}',
            type: "POST",
            dataType: 'json',
            data: function(params) {
                return {
                "_token": "{{ csrf_token() }}",
                search: params.term,
                }
            },
            processResults: function (data, page) {
                return {
                results: data
                };
            }
        }
    })
    

})

</script>

@endpush