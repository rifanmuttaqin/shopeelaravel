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
        <h4>Pengaturan Percetakkan Kartu Ucapan</h4>
    </div>
    <div class="card-body">

        <form  method="post" action="{{route('setting-update')}}">
        
        @csrf

        <div class="form-group">
        <label>Ukuran Kertas</label>
        <select class="form-control" id="paper_size" disabled name="paper_size">
            <option value="A4"> A4 </option>
            <option value="A5"> A5 </option>
            <option value="A6"> A6 </option>
        </select>
        @if ($errors->has('paper_size'))
            <div><p style="color: red"><span>&#42;</span> {{ $errors->first('paper_size') }}</p></div>
        @endif
        </div>

        <div class="form-group">
        <label>Catatan Untuk Customer</label> <small style="color: blue">(*untuk menyebut nama customer, gunakan string __customer_name__ pada kalimat) </small>
            <textarea style="width: 100%; height: 200px;" type="text" class="form-control form-control-user" name ="customer_note" id="customer_note">{{ !empty($data_user_setting) ? $data_user_setting->customer_note : '' }}</textarea>
        @if ($errors->has('customer_note'))
            <div><p style="color: red"><span>&#42;</span> {{ $errors->first('customer_note') }}</p></div>
        @endif
        </div>
        
    </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Pengaturan WA Gateway</h4>
        </div>
        <div class="card-body">
        
            <div class="form-group">
            <label>Server</label>
                <input type="text" class="form-control form-control-user" name ="ip_server_wa" id="ip_server_wa" value="{{ !empty($data_user_setting->ip_server_wa) ? $data_user_setting->ip_server_wa : '' }}">
            </div>
    
            <div class="form-group">
            <label>Pesan WA</label> <small style="color: blue">(*untuk menyebut nama customer, gunakan string __customer_name__ pada kalimat) </small>
                <textarea style="width: 100%; height: 200px;" type="text" class="form-control form-control-user" name ="wa_message" id="wa_message">{{ !empty($data_user_setting->wa_message) ? $data_user_setting->wa_message : '' }}</textarea>
            @if ($errors->has('customer_note'))
                <div><p style="color: red"><span>&#42;</span> {{ $errors->first('wa_message') }}</p></div>
            @endif
            </div>
            
            <div class="form-group">
                <button type="submit" id="submit" class="btn btn-info pull-right"> SIMPAN </button>            
            </div>
            
            </form>
    
        </div>
        </div>
</div>
</div>


@endsection

@push('scripts')

<script type="text/javascript">

$(function () {
    
    $("#paper_size").val("{{!empty($data_user_setting) ? $data_user_setting->paper_size : '' }}");

})

</script>

@endpush