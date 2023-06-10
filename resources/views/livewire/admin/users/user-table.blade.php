<div>
    <div class="content">
        <div class="container-fluid">

            {{--            @if(session()->has('message'))--}}
            {{--            <div class="alert alert-success alert-dismissible fade show" role="alert">--}}
            {{--                <strong><i class="fa fa-check-circle"></i> {{session('message')}}</strong>--}}
            {{--                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>--}}
            {{--            </div>--}}
            {{--            @endif--}}

            @include('livewire.admin.alerts')

            <div class="row">
                <div class="col-lg-12 mr">
                    <div class="d-flex justify-content-between mb-2">
                        <button wire:click.prevent="addNew" class="btn btn-primary"><i
                                class="fa fa-plus-circle mr-1"></i> Add New User
                        </button>
                        <x-search-input wire:model="searchTerm" var="searchTerm"/>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Options</th>
                                </tr>
                                </thead>

                                <tbody wire:loading.class="text-muted" wire:poll.10s="render">
                                @if(isset($users))
                                    @forelse($users as $user)
                                        <tr>
                                            <th scope="row">{{$user -> id}}</th>
                                            <th scope="row"><img src="{{ getImageUrl($user->image, 'User') }}"
                                                                 style="width: 50px;" class="img img-circle mr-1">
                                            </th>
                                            <td>{{$user -> name}}</td>
                                            <td>{{$user -> email}}</td>
                                            <td>{{$user -> date}}</td>
                                            <td>
                                                <a href="" wire:click.prevent="edit({{$user->id}})">
                                                    <i class="fa fa-edit mr-2"></i>
                                                </a>

                                                <a href="" wire:click.prevent="delete({{$user->id}})">
                                                    <i class="fa fa-trash text-danger"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty

                                        <tr class="text-center">
                                            <td colspan="6">No results found</td>
                                        </tr>
                                    @endforelse
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
{{--                            @if ($users->isNotEmpty() && $users->hasPages())--}}
{{--                                {{ $users->links() }}--}}
{{--                            @endif--}}
                            @if($loadButton)
                            <button wire:click.prevent="loadMore" class="btn btn-primary"><i
                                    class="fa fa-plus-circle mr-1"></i> Load more
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>



   @include('livewire.admin.users.modal')


</div>

