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

                <div style="padding-bottom: 20px">
                    <button type="button"  data-toggle="modal" data-target="#createModal" class="btn btn-info"> @lang('CREATE') &nbsp; <i class="fas fa-plus-square"></i> </button>
                </div>

                <div style="width: 100%; padding-left: -10px;">
                    <div class="table-responsive">
                        <table id="table_result" class="table table-bordered data-table display nowrap" style="width:100%">
                            <thead style="text-align:center;">
                                <tr>
                                    <th> Kategori / Akun </th>
                                    <th> Tipe </th>
                                    <th> Catatan / Keterangan </th>
                                    <th style="width: 10%">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div> 
            </div>
    </div>
    </div>
</div>

@endsection

@section('modal')

@component('components.createupdate')
    @slot('idmodal')
        createModal
    @endslot
    @slot('modaltitle')
        @lang('Create')
    @endslot
    @slot('content')
        <div class="form-group">
            <label>@lang('Category Name')</label>
            <input type="text" class="form-control" name="category_name" id="category_name">
        </div>
        <div class="form-group">
            <label for="sel1">@lang('Type')</label>
            <select class="form-control" id="type" name="type">
                <option value="10">@lang('Receipt')</option>                   
                <option value="20">@lang('Spending')</option>                   
            </select>
        </div>
        <div class="form-group">
            <label>@lang('Note')</label>
            <textarea type="text" class="form-control" name="note" id="note"></textarea>
        </div>

        <button id="save" type="button"  class="btn btn-info"> @lang('SAVE') </button>

    @endslot
@endcomponent

@endsection

@push('scripts')

<script type="text/javascript">

$( document ).ready(function() {
    table = $('#table_result').DataTable({
        processing: true,
        serverSide: true,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true,
        ajax: "#",
        columns: [
            {data: 'category_name', name: 'category_name'},
            {data: 'type', name: 'type'},
            {data: 'note', name: 'note'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('#save').click(function(){
        
        $.ajax({
            type:'POST',
            url: '{{route("cash-flow-component-store")}}',
            data:
            {
                "_token": "{{ csrf_token() }}",
                category_name : $('#category_name').val(),
                type : $('#type').val(),
                note : $('#note').val(),              
            },
            success:function(data) {
                
                $("#createModal").modal('hide');

                if(data.status == true)
                {
                    swal(data.message, { button:false, icon: "success", timer: 1000});
                    table.ajax.reload();
                }
                else
                {
                    swal('Terjadi kesalahan', { button:false, icon: "error", timer: 1000});
                }
            
            }
        });


    });

});

</script>

@endpush