<div>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    @livewire('admin.users.user-table')

{{--    <div class="content">--}}
{{--        <div class="container-fluid" >--}}

{{--            --}}{{--            @if(session()->has('message'))--}}
{{--            --}}{{--            <div class="alert alert-success alert-dismissible fade show" role="alert">--}}
{{--            --}}{{--                <strong><i class="fa fa-check-circle"></i> {{session('message')}}</strong>--}}
{{--            --}}{{--                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>--}}
{{--            --}}{{--            </div>--}}
{{--            --}}{{--            @endif--}}

{{--            @include('livewire.admin.alerts')--}}

{{--            <div class="row">--}}
{{--                <div class="col-lg-12 mr">--}}
{{--                    <div class="d-flex justify-content-between mb-2">--}}
{{--                        <button wire:click.prevent="addNew" class="btn btn-primary"><i--}}
{{--                                class="fa fa-plus-circle mr-1"></i> Add New User--}}
{{--                        </button>--}}
{{--                        <x-search-input wire:model="searchTerm" var="searchTerm"/>--}}
{{--                    </div>--}}

{{--                    <div class="card">--}}
{{--                        <div class="card-body">--}}
{{--                            <table class="table table-hover">--}}
{{--                                <thead>--}}
{{--                                <tr>--}}
{{--                                    <th scope="col">#</th>--}}
{{--                                    <th scope="col">Image</th>--}}
{{--                                    <th scope="col">Name</th>--}}
{{--                                    <th scope="col">Email</th>--}}
{{--                                    <th scope="col">Date</th>--}}
{{--                                    <th scope="col">Options</th>--}}
{{--                                </tr>--}}
{{--                                </thead>--}}
{{--                                <tbody wire:loading.class="text-muted" wire:poll.10s="render">--}}
{{--                                @if(isset($users))--}}
{{--                                    @forelse($users as $user)--}}
{{--                                            <tr>--}}
{{--                                                <th scope="row">{{$user -> id}}</th>--}}
{{--                                                                                            <th scope="row"><img src="{{ asset('uploads/User/'.$user->image) }}"></th>                                            <td>{{$user -> name}}</td>--}}
{{--                                                <th scope="row"><img src="{{ getImageUrl($user->image, 'User') }}"--}}
{{--                                                                     style="width: 50px;" class="img img-circle mr-1">--}}
{{--                                                </th>--}}
{{--                                                <td>{{$user -> name}}</td>--}}
{{--                                                <td>{{$user -> email}}</td>--}}
{{--                                                <td>{{$user -> date}}</td>--}}
{{--                                                <td>--}}
{{--                                                    <a href="" wire:click.prevent="edit({{$user->id}})">--}}
{{--                                                        <i class="fa fa-edit mr-2"></i>--}}
{{--                                                    </a>--}}

{{--                                                    <a href="" wire:click.prevent="delete({{$user->id}})">--}}
{{--                                                        <i class="fa fa-trash text-danger"></i>--}}
{{--                                                    </a>--}}
{{--                                                </td>--}}
{{--                                            </tr>--}}
{{--                                            @empty--}}

{{--                                                <tr class="text-center">--}}
{{--                                                    <td colspan="6">No results found</td>--}}
{{--                                                </tr>--}}
{{--                                    @endforelse--}}
{{--                                @endif--}}
{{--                                </tbody>--}}
{{--                            </table>--}}
{{--                        </div>--}}
{{--                        <div class="card-footer d-flex justify-content-end">--}}
{{--                            @if ($users->isNotEmpty() && $users->hasPages())--}}
{{--                                {{ $users->links() }}--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <!-- /.row -->--}}
{{--        </div><!-- /.container-fluid -->--}}
{{--    </div>--}}


    <!-- Modal -->
{{--    <div class="modal fade" id="form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"--}}
{{--         wire:ignore.self>--}}
{{--        <div class="modal-dialog">--}}

{{--            <form id="userForm" wire:submit.prevent="set">--}}

{{--                <div class="modal-content">--}}
{{--                    <div class="modal-header">--}}
{{--                        <h1 class="modal-title fs-5" id="exampleModalLabel">--}}
{{--                            @if($showEditModal)--}}
{{--                                <span>Edit User</span>--}}
{{--                            @else--}}
{{--                                <span>Add New User</span>--}}
{{--                            @endif--}}
{{--                        </h1>--}}
{{--                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                    </div>--}}
{{--                    <div class="modal-body">--}}

{{--                        <div class="mb-3">--}}
{{--                            <label for="name" class="form-label">Name</label>--}}
{{--                            <input type="text" wire:model.lazy="state.name"--}}
{{--                                   class="form-control @error('state.name') is-invalid @enderror" id="name"--}}
{{--                                   aria-describedby="nameHelp" placeholder="Enter full name">--}}
{{--                            @error('state.name')--}}
{{--                            <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                            @enderror--}}
{{--                        </div>--}}

{{--                        <div class="mb-3">--}}
{{--                            <label for="date" class="form-label">Date</label>--}}
{{--                            <x-inputs.date wire:model="state.date" id="date" placeholder="MM/DD/YYYY" class="form-control"/>--}}

{{--                        </div>--}}

{{--                        <div class="mb-3">--}}
{{--                            <label for="email" class="form-label">Email address</label>--}}
{{--                            <input type="email" wire:model.lazy="state.email"--}}
{{--                                   class="form-control @error('state.email') is-invalid @enderror" id="email"--}}
{{--                                   aria-describedby="emailHelp" placeholder="Enter email">--}}
{{--                            @error('state.email')--}}
{{--                            <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                            @enderror--}}
{{--                        </div>--}}

{{--                        <div class="mb-3">--}}
{{--                            <label for="password" class="form-label">Password</label>--}}
{{--                            <input type="password" wire:model.defer="state.password"--}}
{{--                                   class="form-control @error('password') is-invalid @enderror" id="password"--}}
{{--                                   placeholder="Enter password">--}}
{{--                            @error('password')--}}
{{--                            <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                            @enderror--}}
{{--                        </div>--}}

{{--                        <div class="mb-3">--}}
{{--                            <label for="password_confirmation" class="form-label">Confirm Password</label>--}}
{{--                            <input type="password" wire:model.defer="state.password_confirmation" class="form-control"--}}
{{--                                   id="password_confirmation" placeholder="Confirm password">--}}
{{--                        </div>--}}

{{--                        <div class="mb-3">--}}
{{--                            <label for="Image" class="form-label">Image</label>--}}
{{--                            <div x-data="{isUploading: false, progress: 5}"--}}
{{--                                 x-on:livewire-upload-start="isUploading = true"--}}
{{--                                 x-on:livewire-upload-finish="isUploading = false; progress = 5"--}}
{{--                                 x-on:livewire-upload-error="isUploading = false"--}}
{{--                                 x-on:livewire-upload-progress="progress=$event.detail.progress;">--}}
{{--                                <input type="file"  wire:model="state.image" class="form-control"--}}
{{--                                       id="image" placeholder="Upload file"/>--}}
{{--                                <div x-show.transition="isUploading" class="progress progress-sm mt-2 rounded">--}}
{{--                                    <div class="progress-bar bg-primary progress-bar-striped" role="progressbar"--}}
{{--                                         aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"--}}
{{--                                         x-bind:style="`width: ${progress}%`">--}}
{{--                                        <span class="sr-only">40% Complete (success)</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}


{{--                            @if(@$state['id'])--}}
{{--                                <img--}}
{{--                                    src="{{ @$state['tempImage'] ? $state['tempImage']->temporaryUrl(): getImageUrl(@$state['image'], 'User') }}"--}}
{{--                                    class="img d-block mt-2 w-100 rounded" alt="Image">--}}
{{--                            @elseif(@$state['tempImage'])--}}
{{--                                <img src="{{$state['tempImage']->temporaryUrl()}}"--}}
{{--                                     class="img d-block mt-2 w-100 rounded" alt="Image">--}}
{{--                            @endif--}}


{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="modal-footer">--}}
{{--                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">--}}
{{--                            <id class="fa fa-times mr-1"></id>--}}
{{--                            Cancel--}}
{{--                        </button>--}}
{{--                        <button id="submitBtn" type="submit" class="btn btn-primary" wire:loading.attr="disabled">--}}
{{--                            <id class="fa fa-save mr-1"></id>--}}
{{--                            Save--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--            </form>--}}
{{--        </div>--}}

{{--    </div>--}}

    <x-confirmation-alert/>

</div>


