<?php

namespace App\Http\Livewire\Admin\Appointments;

use App\Http\Requests\AppoitmentRequest;
use App\Models\Appointment;
use App\Models\Client;
use Livewire\Component;

class CreateAppointmentForm extends Component
{
    protected $modelPath = 'App\Models\Appointment';
    public $date;
    public $time;
    public $state = [];
    public $appointment;



    public function updatedDate(){$this->state['date'] = $this->date;}
    public function updatedTime(){$this->state['time'] = $this->time;}

    public function mount($id = null){

        if ($id) {
            $this->edit = true;
            $this->appointment = Appointment::firstWhere('id', $id);
            $this->state = $this->appointment->toArray();
        }

    }

    public function setAppointment(){

//        $request = new AppoitmentRequest();
//        $request->withState($this->state)->validate($request->rules());
        dd($this->state);
        updateOrStore($this->state, $this->modelPath, 0);
    }

//    public function updateAppointment(){
//
//        $request = new AppoitmentRequest();
//        $request->withState($this->state)->validate($request->rules());
//
//        $this->appointment->update($this->state);
//    }
//
//    public function createAppointment(){
//
//        $request = new AppoitmentRequest();
//        $request->withState($this->state)->validate($request->rules());
//
//        $appointment = Appointment::create($this->state);
//    }


    public function render()
    {
        $data['clients'] = Client::all();
        return view('livewire.admin.appointments.create-appointment-form', $data);
    }
}
