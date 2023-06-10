<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Appointments</h1>
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
                        <div>
                            <a href="{{route('admin.appointments.create')}}">
                                <button class="btn btn-primary"><i
                                        class="fa fa-plus-circle mr-1"></i> Add New Appointment
                                </button>
                            </a>

                            @if($selectedRows)
                                <div class="btn-group ml-2">
                                    <button type="button" class="btn btn-default">Bulk Actions</button>
                                    <button type="button" class="btn btn-default dropdown-toggle dropdown-icon"
                                            data-toggle="dropdown">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <a wire:click.prevent="bulkActions('deleteAll')" class="dropdown-item" href="#">Delete
                                            Selected</a>
                                        <a wire:click.prevent="bulkActions('allClosed')" class="dropdown-item" href="#">Mark
                                            as Closed</a>
                                        <a wire:click.prevent="export" class="dropdown-item" href="#">Export</a>
                                    </div>
                                </div>
                            @endif
                            <span
                                class="ml-2">selected {{ count($selectedRows) }} {{ Str::plural('appointment', count($selectedRows)) }}</span>

                        </div>

                        <div>
                            <a href="" wire:click.prevent="resetPriceFilters()">Temizle</a>
                            <span>150-300</span>
                            <input wire:model="priceBetween" type="radio" value="150-300">
                            <span>300-500</span>
                            <input wire:model="priceBetween" type="radio" value="300-500">
                            <span>500-750</span>
                            <input wire:model="priceBetween" type="radio" value="500-750">
                            <span>750-1000</span>
                            <input wire:model="priceBetween" type="radio" value="750-1000">
                        </div>

                        <div class="btn-group">
                            <button type="button" class="btn btn-default" wire:click.prevent="fff">
                                <span class="mr-1">All</span>
                                <span class="badge badge-pill badge-info">{{$appointmentCount}}</span>
                            </button>
                            <select wire:model="filters.gender" wire:click.prevent="checkFilter('gender')">
                                <option value="">Choose Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>

                            <select wire:model="filters.status" wire:click.prevent="checkFilter('status')">
                                <option value="">Choose Status</option>
                                <option value="SCHEDULED">Scheduled</option>
                                <option value="CLOSED">Closed</option>
                            </select>

                            <form wire:submit.prevent="setPrice">
                                <input wire:model.defer="priceFilters.minPrice" type="text" class="form-control"
                                       placeholder="en az">
                                <input wire:model.defer="priceFilters.maxPrice" type="text" class="form-control"
                                       placeholder="en cok">
                                <button type="submit">do it</button>
                            </form>

                            {{--                            @foreach($filters as $key => $value)--}}
                            {{--                            <x-filters :type="$key" :objects="$value"/>--}}
                            {{--                            @endforeach--}}
                        </div>
                    </div>


                    List Of Users
                    <a class="btn btn-danger float-end" wire:click.prevent="export('all')">Export All Records</a>


                    <form wire:submit.prevent="importFile">
                        <input wire:model="file" type="file" name="file" class="form-control">
                        <br>
                        <button class="btn btn-primary" wire:target="file"
                                wire:loading.attr="disabled" {{$file ? '' : 'disabled'}}>Import User Data
                        </button>
                    </form>

                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>
                                        <div
                                            class="icheck-primary d-inline ml-2">
                                            <input wire:model="selectPageRows" type="checkbox" value="" name="todo2"
                                                   id="todoCheck2">
                                            <label for="todoCheck2"></label>
                                        </div>
                                    </th>
                                    <th scope="col">#</th>
                                    <th scope="col">Client Name</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Options</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($appointments) && $appointments->count())
                                    @foreach($appointments as $appointment)
                                        <tr>
                                            <th>
                                                <div class="icheck-primary d-inline ml-2">
                                                    <input wire:model="selectedRows" type="checkbox"
                                                           value="{{$appointment->id}}"
                                                           name="todo2" id="{{$appointment->id}}">
                                                    <label for="{{$appointment->id}}"></label>
                                                </div>
                                            </th>
                                            <th scope="row">{{$appointment -> id}}</th>
                                            <td>{{@$appointment -> client -> name}}</td>
                                            <td>{{@$appointment -> date}}</td>
                                            <td>{{@$appointment -> time}}</td>
                                            <td><span
                                                    class="badge badge-{{@$appointment->status_badge}}">{{$appointment->status}}</span>
                                            </td>
                                            <td><span
                                                    class="badge badge-{{@$appointment->gender_badge}}">{{$appointment->gender}}</span>
                                            </td>
                                            <td>{{@$appointment -> price}}</td>
                                            <td>
                                                <a href="{{route('admin.appointments.edit', $appointment->id)}}">
                                                    <i class="fa fa-edit mr-2"></i>
                                                </a>

                                                <a href="" wire:click.prevent="delete({{$appointment->id}})">
                                                    <i class="fa fa-trash text-danger"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex justify-content-end">

                            {{ $appointments->links() }}

                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>


    <x-confirmation-alert/>

</div>
<script>
    document.addEventListener("livewire:load", function () {
        Livewire.hook('afterDomUpdate', function () {
            Livewire.on('pageChanged', function () {
                // Execute your desired action here
                alert('erherh')
            });
        });
    });
</script>
