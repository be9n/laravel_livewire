<div class="modal fade" id="form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
     wire:ignore.self>
    <div class="modal-dialog">
        {{ $slot }}
    </div>

</div>


<script>
    window.addEventListener('hide-modal', event => {
        $('#' + event.detail.modal_id).modal('hide');

        alertUp(event.detail.message, event.detail.alert_type)

        $("#userForm")[0].reset();
    });

    window.addEventListener('show-modal', event => {
        if (event.detail.create) {
            $("#userForm")[0].reset();
        }
        var modal_id = event.detail.modal_id
        $('#' + modal_id).modal('show');
    });
</script>
