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

@component('components.createupdate')
    @slot('idmodal')
        updateModal
    @endslot
    @slot('modaltitle')
        @lang('Update')
    @endslot
    @slot('content')

        <input type="hidden" name="id_update" id="id_update">

        <div class="form-group">
            <label>@lang('Category Name')</label>
            <input type="text" class="form-control" name="category_name" id="category_name_update">
        </div>
        <div class="form-group">
            <label for="sel1">@lang('Type')</label>
            <select class="form-control" id="type_update" name="type">
                <option value="10">@lang('Receipt')</option>                   
                <option value="20">@lang('Spending')</option>                   
            </select>
        </div>
        <div class="form-group">
            <label>@lang('Note')</label>
            <textarea type="text" class="form-control" name="note" id="note_update"></textarea>
        </div>

        <button id="update" type="button"  class="btn btn-info"> @lang('UPDATE') </button>

    @endslot
@endcomponent


@endsection

@push('scripts')

<script type="text/javascript">

function updateAction(param)
{
    setupFormUpdate(param);
    $('#updateModal').modal('toggle');
}

function setupFormUpdate(param)
{
    $('#category_name_update').val(param.category_name);
    $('#type_update').val(param.type).change();
    $('#note_update').val(param.note);
    $('#id_update').val(param.id);
}

function deleteAction(id)
{
    var cashFlowComponent = id;

    // Tampilkan konfirmasi SweetAlert
    swal({
        title: 'Konfirmasi',
        text: 'Anda yakin ingin menghapus item ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((willDelete) => {     
        if(willDelete)
        {
            var url = "{{ route('cash-flow-component-delete', ':id') }}";
           
            $.ajax({
                type:'DELETE',
                url: url.replace(':id', cashFlowComponent),
                data:
                {
                    "_token": "{{ csrf_token() }}",
                    cashFlowComponent : cashFlowComponent,    
                },
                success:function(data) {
                    swal(data.message, { button:false, icon: "success", timer: 1000});
                    table.ajax.reload();
                }
            });

        }   
        return false;
    
    });
}

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

    $('#update').click(function(){
        
        var cashFlowComponent = $('#id_update').val();
        var url = "{{ route('cash-flow-component-update', ':id') }}";

        $.ajax({
            type:'PUT',
            url: url.replace(':id', cashFlowComponent),
            data:
            {
                "_token": "{{ csrf_token() }}",
                category_name : $('#category_name_update').val(),
                type : $('#type_update').val(),
                note : $('#note_update').val(),          
            },
            success:function(data) {
                
                $("#updateModal").modal('hide');

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