<?php

namespace App\Imports;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    public $clients;

    public function __construct()
    {
        $this->clients = Client::get();
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $client = $this->clients->where('name', $row['name'])->first();


            return new Appointment([
                'client_id' => $client->id,
                'date' => $row['appointment_date'],
                'time' => $row['appointment_time'],
            ]);

    }
}
