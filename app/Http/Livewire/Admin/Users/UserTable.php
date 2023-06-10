<?php

namespace App\Http\Livewire\Admin\Users;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\User;
use Livewire\Component;

class UserTable extends AdminComponent
{
    public $modelPath = 'App\Models\User';
    protected $listeners = ['deleteConfirmed' => 'delete', 'dispatchUserAddedEvent'];
    public $paginateCount = 10;
    public $loadButton = false;
    public $user;
    public $showEditModal = false;
    public $searchTerm = null;
//    public $tempImage;
    public $state = [];
    public $date;
    public $show = false;

    public function getRules()
    {
        $rules = [
            'state.name' => 'required|min:6',
            'state.email' => 'required|email|unique:users,email,' . @$this->user->id,
        ];
        return $rules;
    }

    public function mount(){
        $this->checkLoad();
    }

    public function updatedStateImage()
    {
        $this->state['tempImage'] = $this->state['image'];
    }

    public function updatedDate(){
        dd('wegw');
        $this->state['date'] = $this->date;
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

    public function loadMore(){
        $this->paginateCount += 10;
        $this->checkLoad();
    }

    public function checkLoad(){
        $usersCount = User::count();
        if ($usersCount > $this->paginateCount)
            $this->loadButton = true;
        else
            $this->loadButton = false;
    }

    public function render()
    {
        $data['users'] = User::query()
            ->where('name', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('email', 'like', '%' . $this->searchTerm . '%')
            ->paginate($this->paginateCount);

        return view('livewire.admin.users.user-table', $data);
    }
}
