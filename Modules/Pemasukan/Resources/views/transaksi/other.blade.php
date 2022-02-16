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

        <form  method="post" action="{{ route('transaksi-offline-other-store') }}" enctype="multipart/form-data">

        @csrf
        
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

        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Total Belanja</label>
                <input onkeyup="setDiskon()" type="text" id="total_belanja" class="form-control form-control-user" value="0">
            </div>
               
            <div class="form-group col-md-6">
                <label>Diskon</label>
                <input onkeyup="setDiskon()" type="text" class="form-control form-control-user" name ="discount_amount" id="discount_amount">
                @if ($errors->has('discount_amount'))
                        <div><p style="color: red"><span>&#42;</span> {{ $errors->first('discount_amount') }}</p></div>
                @endif
            </div>
        </div>

        <div class="form-row" style="padding-top: 10px">
            <div class="form-group col-md-6"></div>
            <div class="form-group col-md-6">
                <label>Total Bayar</label>
                <input readonly type="text" class="form-control form-control-user" name ="total_amount" id="total_amount">
                @if ($errors->has('total_amount'))
                        <div><p style="color: red"><span>&#42;</span> {{ $errors->first('total_amount') }}</p></div>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label for="sel1" style="color: rgb(85, 82, 82)"><strong>Keterangan</strong></label>
            <input type="text" id="keterangan" name="keterangan" class="form-control form-control-user">
        </div>


        <div class="form-group">
            <label for="sel1" style="color: rgb(85, 82, 82)"><strong>Status Pembayaran</strong></label>
            <select class="form-control" id="status_transaksi" name="status_transaksi">
                <option value="10"> LUNAS </option>
                <option value="20"> BELUM LUNAS </option>                         
            </select>
        </div>
       

        <div class="form-group" style="padding-top: 20px">
            <button type="submit" class="btn btn-info"> Proses </button>
        </div>

        </form>

        </div>
</div>
</div>

@endsection

@push('scripts')

<script type="text/javascript">

function setDiskon() {
    
    var myEle = document.getElementById("total_belanja");

    if(myEle){
        let diskon = $('#discount_amount').val();
        let real_amount = $('#total_belanja').val();
        $('#total_amount').val(real_amount-diskon);
    }   

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

})

</script>

@endpush