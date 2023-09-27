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
                    <button type="button"  onclick="clearfrom()" data-toggle="modal" data-target="#createModal" class="btn btn-info"> @lang('CREATE') &nbsp; <i class="fas fa-plus-square"></i> </button>
                </div>

                <div style="width: 100%; padding-left: -10px;">
                    <div class="table-responsive">
                        <table id="table_result" class="table table-bordered data-table display nowrap" style="width:100%">
                            <thead style="text-align:center;">
                                <tr>
                                    <th> Akun / Master </th>
                                    <th> Tipe </th>
                                    <th> Amount </th>
                                    <th> Note </th>
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
    <form id="createForm" >
        
    </form>

    <button id="save" type="button"  class="btn btn-info"> @lang('SAVE') </button>

    @endslot
@endcomponent

@endsection

@push('scripts')

<script type="text/javascript">

function clearfrom()
{
    var form = $("#createForm");
    form[0].reset();
}

function deleteAction(id)
{
    var CashFlowTransaction = id;

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
            var url = "{{ route('cash-flow-transaction-delete', ':id') }}";
           
            $.ajax({
                type:'DELETE',
                url: url.replace(':id', CashFlowTransaction),
                data:
                {
                    "_token": "{{ csrf_token() }}",
                    CashFlowTransaction : CashFlowTransaction,    
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
            {data: 'cash_flow_camponent_id', name: 'cash_flow_camponent_id'},
            {data: 'type', name: 'type'},
            {data: 'amount', name: 'amount'},
            {data: 'note', name: 'note'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('#save').click(function(){
        
        $.ajax({
            type:'POST',
            url: '{{route("cash-flow-transaction-store")}}',
            data:
            {
                "_token": "{{ csrf_token() }}",
                     
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