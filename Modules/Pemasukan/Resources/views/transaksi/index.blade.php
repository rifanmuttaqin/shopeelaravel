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

        <form  method="post" action="{{ route('transaksi-offline-store')}}" enctype="multipart/form-data">
        
        <div class="form-row" style="padding-top: 10px">
            <div class="form-group col-sm text-right">
                <div class="card">
                    <div class="card-body">
                        <h1 class="total_amount"> 0 </h1>
                    </div>
                  </div>
            </div>
            <div class="form-group col-sm">
                <label>@lang('Tanggal')</label>
                <input type="text" class="form-control form-control-user" name ="date" id="date" placeholder="">
                @if ($errors->has('date'))
                    <div><p style="color: red"><span>&#42;</span> {{ $errors->first('date') }}</p></div>
                @endif
            </div>
            <div class="form-group col-sm">
                <label>Customer</label>
                <select style="width: 100%" class="form-control form-control-user select2-class" name="nama_customer" id="nama_customer">
                </select>
                @if ($errors->has('nama_customer'))
                        <div><p style="color: red"><span>&#42;</span> {{ $errors->first('nama_customer') }}</p></div>
                @endif
            </div>
        </div>

        @csrf

        {{-- <div class="form-group">
            <div class="form-group">
                
            </div>
        </div> --}}

        <input type="hidden" name="produk_chart" id="produk_chart">

        <div class="form-row">
            <div class="form-group col-md-6">
                <div class="form-group">
                    <label>Produk</label>
                    <select style="width: 100%" class="form-control form-control-user select2-class" name="nama_produk" id="nama_produk">
                    </select>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label>QTY</label>
                <input type="number" class="form-control form-control-user" id="qty_beli">
            </div>

            <div class="form-group col-md-2">
                <div style="padding-top: 30px">
                    <button type="button" id="add_chart" class="btn btn-info"> <i class="fas fa-plus-square"></i> </button>
                </div>
            </div>
        </div>
        
        <div id="temp_table">
        <div style="width: 100%; padding-left: -10px;">
            <div class="table-responsive">
            <table id="table_result" class="table table-bordered data-table display nowrap" style="width:100%">
            <thead style="text-align:center;">
                    <tr>
                        <th style="width: 30%">Barang</th>
                        <th style="width: 30%">Harga</th>
                        <th style="width: 10%">Qty</th>
                        <th style="width: 30%">Total</th>
                        <th style="width: 30%">Action</th>
                    </tr>
            </thead>
                <tr>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>                    
                </tr>
            <tbody>
            </tbody>
            </table>
            </div>
        </div>
        </div>
        <div class="form-row total" style="padding-top: 10px">
            <div class="form-group col-md-6">
            </div>
            <div class="form-group col-md-6">
                <label>Total</label>
                <input type="text" disabled class="form-control form-control-user" value="0">
            </div>
        </div>
        <div class="form-row" style="padding-top: 10px">
            <div class="form-group col-md-6"></div>
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


let table_result;
let array_chart = [];

function setDiskon() {
    var myEle = document.getElementById("total_amount_real");
    if(myEle){
        let diskon = $('#discount_amount').val();
        let real_amount = $('#total_amount_real').val();
        $('#total_amount').val(real_amount-diskon);
        $('.total_amount').text(real_amount-diskon);
    }   
}

function setFormProduk(param) {
    $('#produk_chart').val(param);
    $('#total_amount').val($('#total_amount_real').val());
    $('.total_amount').text($('#total_amount_real').val());
}

function clearProdukForm() {
    $("#nama_produk").val(null).trigger('change');
    $("#qty_beli").val(null);
    $('.total').hide();
}

function deleteArray(param)
{
    array_chart.splice(param, 1);
    request = $.ajax({
        url: "{{ route('transaksi-offline-addchart') }}",
        type: "post",
        data: {array_chart,"_token": "{{ csrf_token() }}"}
    });

    request.done(function (response, textStatus, jqXHR){
        $('#temp_table').html(response);
        setFormProduk(array_chart);
    });
}

$(function () { 

    // ----- ADD CHART CLICK ------
    $( "#add_chart" ).click(function() {
        let produk = $('#nama_produk').select2('data');
        let qty = $('#qty_beli').val();
        
        array_chart.push(JSON.stringify({'id_produk':produk[0].id,'qty':qty}));
        
        request = $.ajax({
            url: "{{ route('transaksi-offline-addchart') }}",
            type: "post",
            data: {array_chart,"_token": "{{ csrf_token() }}"}
        });

        request.done(function (response, textStatus, jqXHR){
            $('#temp_table').html(response);
            setFormProduk(array_chart);
            clearProdukForm();
        });

        return false;
    });

    $('#nama_produk').select2({
        allowClear: true,
        placeholder:'Produk',
        ajax: {
            url: '{{ route("produk-list") }}',
            type: "POST",
            dataType: 'json',
            data: function(params) {
                return {
                "_token": "{{ csrf_token() }}",
                search: params.term,
                type_product : 'harga',
                }
            },
            processResults: function (data, page) {
                return {
                results: data
                };
            }
        }
    })

    $('#date').daterangepicker({
        autoUpdateInput: true,
        singleDatePicker: true,
        locale: {cancelLabel: 'Bersihkan',format: "D MMMM Y"}
    });


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