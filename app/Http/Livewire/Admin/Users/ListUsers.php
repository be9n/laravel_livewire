<?php

namespace App\Http\Livewire\Admin\Users;

use App\Events\UserAddedEvent;
use App\Http\Livewire\Admin\AdminComponent;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Traits\UserValidationTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ListUsers extends AdminComponent
{
    public $modelPath = 'App\Models\User';
    protected $listeners = ['deleteConfirmed' => 'delete', 'dispatchUserAddedEvent'];

    public $user;
    public $showEditModal = false;
    public $searchTerm = null;
    public $tempImage;
    public $state = [];
    public $date;
    public $users;

    public function updatedDate($value){
        $this->state['date'] = $this->date;
    }


    public function getRules()
    {
        $rules = [
            'state.name' => 'required|min:6',
            'state.email' => 'required|email|unique:users,email,' . @$this->user->id,
        ];
        return $rules;
    }

    public function edit($user_id)
    {

        $this->resetValidation();
        $user = User::firstWhere('id', $user_id);

            $this->showEditModal = true;

            $this->user = $user;


            $this->state = $user->toArray();


            $this->dispatchBrowserEvent('show-modal', ['modal_id' => 'form']);

    }

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function set()
    {

        $this->validate();

//        if (@$this->state['tempImage'])
//            $this->state['image'] = $this->state['tempImage'];


        if (@$this->state['image'] == @$this->user->image)
            unset($this->state['image']);

        updateOrStore($this->state, $this->modelPath, 0);
        $this->emitTo('admin.users.user-table', 'refresh');
        $this->dispatchBrowserEvent('hide-modal', ['modal_id' => 'form', 'message' => 'User added successfully!', 'alert_type' => 'alert-success']);
    }

    public function addNew()
    {
        // $this->resetValidation();
        $this->state = [];
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-modal', ['modal_id' => 'form', 'create' => true]);
    }

    public function delete($user_id = null)
    {

        if ($user_id) {

            $this->dispatchBrowserEvent('show-delete-modal');
            $user = User::firstWhere('id', $user_id);
            $this->user = $user;
            return;
        }

        if ($this->user) {
            $this->user->delete();
            $this->emitTo('admin.users.user-table', 'refresh');
            $this->dispatchBrowserEvent('deleted', ['message' => 'Appointment deleted successfully']);
        }
        $this->user = null;
    }

    public function updatedStateImage()
    {
        $this->state['tempImage'] = $this->state['image'];
    }

    public function refresh()
    {

        return;
    }

    public function updatedSearchTerm()
    {

        $this->resetPage();
    }

    public function render()
    {

        //  $this->refresh();

        $data['users2'] = User::query()
            ->where('name', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('email', 'like', '%' . $this->searchTerm . '%')
            ->get();

        $this->users = $data['users2'];

        return view('livewire.admin.users.list-users', $data);
    }
}
