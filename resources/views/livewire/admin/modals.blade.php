<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
     wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Delete</h5>
            </div>

            <div class="modal-body">
                <h6>Are you sure you want to delete this?</h6>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <id class="fa fa-times mr-1"></id>
                    Cancel
                </button>
                <button type="submit" class="btn btn-danger" wire:click.prevent="delete">
                    <id class="fa fa-remove-format mr-1"></id>
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>
