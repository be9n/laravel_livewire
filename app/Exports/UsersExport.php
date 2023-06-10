<?php
namespace App\Exports;
use App\Models\Client;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class UsersExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Client::select("clients.id", "clients.name", "appointments.date", "appointments.time")
            ->leftJoin("appointments", "clients.id", "=", "appointments.client_id")
            ->orderBy("appointments.date")
            ->get();
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["ID", "Name", 'Appointment Date', 'Appointment Time'];
    }
}
