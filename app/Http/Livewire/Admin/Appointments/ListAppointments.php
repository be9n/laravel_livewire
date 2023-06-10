<?php

namespace App\Http\Livewire\Admin\Appointments;

use App\Exports\AppointmentsExport;
use App\Http\Livewire\Admin\AdminComponent;
use App\Imports\AppointmentsImport;
use App\Models\Appointment;
use Maatwebsite\Excel\Facades\Excel;

class ListAppointments extends AdminComponent
{
    public $paginationCount = 10;

    protected $queryString = [
        'priceFilters' => ['except' => '', 'as' => 'price'],
        'filters' => ['except' => '', 'as' => 'filters', 'glue' => '-'],
    ];

    public $excelHeadings = ["Client ID", "Client Name", 'Date', 'Time', 'Status', 'Gender', 'Price'];

    protected $listeners = ['deleteConfirmed' => 'delete'];
    public $filterValue = null;
    public $type;
    public $appointment;
    public $priceBetween;
    public $priceFilters;
    public $filters = [];
    public $selectPageRows = false;
    public $selectedRows = [];
    public $file;

    public function importFile(){
        Excel::import(new AppointmentsImport($this->excelHeadings),$this->file);
    }

    public function export($action = null)
    {

        if ($action == 'all'){
            $ids = $this->getAppointments()->pluck('id');
        }else{
            $ids = $this->selectedRows;
        }
        return Excel::download(new AppointmentsExport($ids, $this->excelHeadings), 'appointments.xlsx');
    }

    public function bulkActions($action)
    {
        $appointments = Appointment::whereIn('id', $this->selectedRows);
        if ($action == 'deleteAll') {
            $appointments->delete();
            $this->dispatchBrowserEvent('deleted', ['message' => 'Appointments deleted successfully']);
            $this->reset(['selectedRows', 'selectPageRows']);
        } elseif ($action == 'allClosed') {
            $appointments->update(['status' => 'CLOSED']);

        }
    }

    public function updatedSelectPageRows($value)
    {

        if ($value) {
            $this->selectedRows = $this->getAppointments($this->paginationCount)->pluck('id')->map(function ($id) {
                return (string)$id;
            });
        } else {
            $this->reset(['selectedRows', 'selectPageRows']);
        }

    }

    public function getAppointments($paginateCount = null)
    {
        $appointments = Appointment::when($this->filters, function ($query) {
            foreach ($this->filters as $type => $value) {
                if (!$value == null)
                    $query->where($type, '=', $value);
            }
        })->when($this->priceFilters, function ($q) {
            if (@$this->priceFilters['minPrice'] && !@$this->priceFilters['maxPrice']) {
                $q->where('price', '>=', $this->priceFilters['minPrice']);
            } else if (@$this->priceFilters['maxPrice'] && !@$this->priceFilters['minPrice']) {
                $q->where('price', '<=', $this->priceFilters['maxPrice']);
            } else if ($this->priceFilters['minPrice'] && $this->priceFilters['maxPrice']) {
                $q->whereBetween('price', [$this->priceFilters['minPrice'], $this->priceFilters['maxPrice']]);
            }
        })->orderBy('date');

        if ($paginateCount)
            $appointments = $appointments->paginate($paginateCount);
        else
            $appointments = $appointments->get();

            return $appointments;
    }

    public function updatedPriceBetween()
    {
        if ($this->priceBetween != null) {
            $price = explode('-', $this->priceBetween);
            $this->priceFilters['minPrice'] = $price[0];
            $this->priceFilters['maxPrice'] = $price[1];
        }

    }

    public function checkFilter($filter = null)
    {
        if (@$this->filters[$filter] === '') {
            $this->resetFilters($filter);
        }
    }

    public function resetFilters($filter = null)
    {
        $this->filters[$filter] = null;
    }

    public function delete($appointment_id = null)
    {
        if ($appointment_id) {
            $this->dispatchBrowserEvent('show-delete-modal');
            $appointment = Appointment::findOrFail($appointment_id);
            $this->appointment = $appointment;
            return;
        }
        $this->appointment->delete();
        $this->dispatchBrowserEvent('deleted', ['message' => 'Appointment deleted successfully']);
        // $this->dispatchBrowserEvent('hide-modal', ['modal_id' => 'confirmationModal' ,'message' => 'Appointment deleted successfully!', 'alert_type' => 'alert-danger']);
        $this->appointment = null;
    }

    public function setPrice()
    {
        $this->resetPage();

    }

    public function updatedPriceFilters()
    {
        $this->checkPriceFilters();
        $this->priceBetween = null;
    }

    public function checkPriceFilters($filter = null)
    {
        if (@$this->priceFilters['maxPrice'] === '') {
            $this->resetPriceFilters('maxPrice');
        } else if (@$this->priceFilters['minPrice'] === '') {
            $this->resetPriceFilters('minPrice');
        }
    }

    public function resetPriceFilters($filter = null)
    {
        if ($filter)
            $this->priceFilters[$filter] = null;
        else {
            $this->priceFilters = null;
        }

    }

    public function render()
    {

        $data['appointments'] = $this->getAppointments($this->paginationCount);

        $data['appointmentCount'] = Appointment::count();

        return view('livewire.admin.appointments.list-appointments', $data);
    }
}
