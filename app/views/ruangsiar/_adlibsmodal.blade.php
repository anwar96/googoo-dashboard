<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Adlibs</h4>
        </div>
        <div class="modal-body">
            @{{data.text}}
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary btn-update-adlibs" data-id="@{{data.id}}">done</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            
        </div>
    </div>
</div>