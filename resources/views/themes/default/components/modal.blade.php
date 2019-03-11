<div class="row">
    <div class="modal fade {{ $modalName }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog {{ $modalSize }}">
            <div class="modal-content" data-bg="{{ $modalBackground }}">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">{{ $modalLabel }}</h4>
                </div>
                <!-- Modal Body -->
                <div class="modal-body mx-3">
                    <div class="container-fluid">
                        {{ $modalContent }}
                    </div>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    {{ $modalFooter }}
                </div>
            </div>
        </div>
    </div>
</div>