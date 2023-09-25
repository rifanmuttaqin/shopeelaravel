<div class="modal fade" id="{{ $idmodal }}" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">{{ $modaltitle }}</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                {{ $content }}
            </div>

        </div>
    </div>
</div>