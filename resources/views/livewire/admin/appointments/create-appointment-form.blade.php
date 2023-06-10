<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!-- <h1 class="m-0 text-dark">Appointments</h1> -->
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('admin.appointments') }}">Appointments</a>
                        </li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div id="success_msg" class="alert" role="alert" style="display: none;">

                </div>
                <div class="col-md-12">
                    <form autocomplete="off" wire:submit.prevent="setAppointment" wire:ignore.self>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Add New Appointment</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="client">Client:</label>
                                            <select wire:model="state.client_id"
                                                class="form-control @error('client_id') is-invalid @enderror">
                                                <option value="">Select Client</option>
                                                @if(isset($clients))
                                                    @foreach($clients as $client)
                                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('client_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


{{--                                <div class="col-md-6">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label>Select Team Members</label>--}}
{{--                                        <div class="@error('members') is-invalid border border-danger rounded custom-error @enderror">--}}
{{--                                            <x-inputs.select2 wire:model="state.members" id="members" placeholder="Select Members">--}}
{{--                                                <option>One</option>--}}
{{--                                                <option>Alaska</option>--}}
{{--                                                <option>California</option>--}}
{{--                                                <option>Delaware</option>--}}
{{--                                                <option>Tennessee</option>--}}
{{--                                                <option>Texas</option>--}}
{{--                                                <option>Washington</option>--}}
{{--                                            </x-inputs.select2>--}}
{{--                                        </div>--}}
{{--                                        @error('members')--}}
{{--                                        <div class="invalid-feedback">--}}
{{--                                            {{ $message }}--}}
{{--                                        </div>--}}
{{--                                        @enderror--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                                <div class="row">
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Date</label>
                                        <x-inputs.date wire:model="state.date" id="date" placeholder="MM/DD/YYYY" class="form-control"/>

                                    </div>

{{--                                    <div class="col-md-6">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label for="appointmentTime">Appointment Time</label>--}}
{{--                                            <div class="input-group mb-3">--}}
{{--                                                <div class="input-group-prepend">--}}
{{--                                                    <span class="input-group-text"><i class="fas fa-clock"></i></span>--}}
{{--                                                </div>--}}
{{--                                                <x-timepicker wire:model.defer="state.time" id="appointmentTime" :error="'time'"/>--}}
{{--                                                <input type="time" wire:model="time">--}}
{{--                                                <input type="text" wire:model.defer="state.time">--}}
{{--                                                @error('time')--}}
{{--                                                <div class="invalid-feedback">--}}
{{--                                                    {{ $message }}--}}
{{--                                                </div>--}}
{{--                                                @enderror--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="note">Note:</label>
                                            <textarea wire:model.lazy="state.note" id="note"  class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="client">Status:</label>
                                            <select class="form-control @error('status') is-invalid @enderror" wire:model="state.status">
                                                <option value="">Select Status</option>
                                                <option value="SCHEDULED">Scheduled</option>
                                                <option value="CLOSED">Closed</option>
                                            </select>
                                            @error('status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="">
                                    <button type="button" class="btn btn-secondary"><i class="fa fa-times mr-1"></i>
                                        Cancel
                                    </button>
                                </a>
                                <button id="submit" type="submit" class="btn btn-primary"><i
                                        class="fa fa-save mr-1"></i> Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('livewire/admin/appointments/appointment-css')
@include('livewire/admin/appointments/appointment-js')
