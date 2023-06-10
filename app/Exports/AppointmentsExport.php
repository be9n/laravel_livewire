<?php

namespace App\Exports;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AppointmentsExport implements FromCollection, WithHeadings, withMapping
{


    private $selectedRows;
    public $headings = [];

    public function __construct($selectedRows, $headings = null)
    {
        $this->headings = $headings ?? [];
        $this->selectedRows = $selectedRows;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
//        return Appointment::select("clients.id", "clients.name", "appointments.date", "appointments.time")
//            ->leftJoin("clients", "clients.id", "=", "appointments.client_id")
//            ->orderBy("appointments.date")
//            ->get();

//        $data = [];
//
//        foreach ($this->selectedRows as $appointment) {
//            $data[] = [
//                "Client ID" => $appointment->client_id,
//                "Client Name" => $appointment->client->name,
//                "Appointment Date" => $appointment->date,
//                "Appointment Time" => $appointment->time,
//                "Status" => $appointment->status,
//                "Gender" => $appointment->gender,
//                "Price" => $appointment->price,
//            ];
//        }
//        return collect($data);

        return Appointment::whereIn('id', $this->selectedRows)->get();
    }

    public function map($appointment): array
    {
        $arr = [
            'client_id' => $appointment->client_id,
            'client_name' => $appointment->client->name,
            'date' => $appointment->date,
            'time' => $appointment->time,
            'status' => $appointment->status,
            'gender' => $appointment->gender,
            'price' => $appointment->price,
        ];

        foreach ($arr as $heading => $value) {
            array_push($this->headings, $heading);
        }

        return $arr;

    }

    /**
     * Write code on Method
     *
     * @return response()
     */


    public function headings(): array
    {

        return $this->headings;
        // return ["Client ID", "Client Name", 'Appointment Date', 'Appointment Time', 'Status', 'Gender', 'Price'];
    }

}
