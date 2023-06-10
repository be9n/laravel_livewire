<x-modal>
    <form id="userForm" wire:submit.prevent="set">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">
                    @if(@$showEditModal)
                        <span>Edit User</span>
                    @else
                        <span>Add New User</span>
                    @endif
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" wire:model.lazy="state.name"
                           class="form-control @error('state.name') is-invalid @enderror" id="name"
                           aria-describedby="nameHelp" placeholder="Enter full name">
                    @error('state.name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <x-inputs.date wire:model="state.date" id="date" placeholder="MM/DD/YYYY"
                                   class="form-control"/>

                </div>


                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" wire:model.lazy="state.email"
                           class="form-control @error('state.email') is-invalid @enderror" id="email"
                           aria-describedby="emailHelp" placeholder="Enter email">
                    @error('state.email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" wire:model.defer="state.password"
                           class="form-control @error('password') is-invalid @enderror" id="password"
                           placeholder="Enter password">
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" wire:model.defer="state.password_confirmation" class="form-control"
                           id="password_confirmation" placeholder="Confirm password">
                </div>

                <div class="mb-3">
                    <label for="Image" class="form-label">Image</label>
                    <div x-data="{isUploading: false, progress: 5}"
                         x-on:livewire-upload-start="isUploading = true"
                         x-on:livewire-upload-finish="isUploading = false; progress = 5"
                         x-on:livewire-upload-error="isUploading = false"
                         x-on:livewire-upload-progress="progress=$event.detail.progress;">
                        <input type="file" wire:model="state.image" class="form-control"
                               id="image" placeholder="Upload file"/>
                        <div x-show.transition="isUploading" class="progress progress-sm mt-2 rounded">
                            <div class="progress-bar bg-primary progress-bar-striped" role="progressbar"
                                 aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
                                 x-bind:style="`width: ${progress}%`">
                                <span class="sr-only">40% Complete (success)</span>
                            </div>
                        </div>
                    </div>


                    @if(@$state['id'])
                        <img
                            src="{{ @$state['tempImage'] ? $state['tempImage']->temporaryUrl() : getImageUrl(@$state['image'], 'User') }}"
                            class="img d-block mt-2 w-100 rounded" alt="Image">
                    @elseif(@$state['tempImage'])
                        <img src="{{$state['tempImage']->temporaryUrl()}}"
                             class="img d-block mt-2 w-100 rounded" alt="Image">
                    @endif


                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <id class="fa fa-times mr-1"></id>
                    Cancel
                </button>
                <button id="submitBtn" type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                    <id class="fa fa-save mr-1"></id>
                    Save
                </button>
            </div>
        </div>

    </form>
</x-modal>
