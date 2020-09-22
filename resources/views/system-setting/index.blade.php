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

    
        <label>Gunakan Alamat Pada Label</label>
        <form method="post" action="#">            
            <input type="radio" id="male" name="gender" value="male">
            <label for="male">Iya</label><br>
            <input type="radio" id="female" name="gender" value="female">
            <label for="female">Tidak</label><br>
        </form>


        <label>Gunakan Nama Pengirim</label>
        <form method="post" action="#">            
            <input type="radio" id="male" name="gender" value="male">
            <label for="male">Iya</label><br>
            <input type="radio" id="female" name="gender" value="female">
            <label for="female">Tidak</label><br>
        </form>

        <div class="form-group">
            <label>Nama Pengirim</label>
            <input type="text" class="form-control" value="" name="nama">
        </div>
       
        <div class="form-group">
            <button type="submit" class="btn btn-info"> SIMPAN </button>
        </div>
        
    </div>
    </div>
</div>
</div>


@endsection

@push('scripts')

@endpush