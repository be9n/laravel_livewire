<?php

namespace App\Imports;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AppointmentsImport implements ToModel, WithHeadingRow
{
    public $appointments;
    public $headings = [];
    public function __construct($headings)
    {
        $this->headings = $headings;
        $this->appointments = Appointment::get();
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $appointment = $this->appointments->where('client_id', $row['client_id'])->where('date', $row['date'])->first();

//        $arr = [];
//        foreach ($this->headings as $heading){
//            $heading = strtolower(str_replace(' ', '_', $heading));
//            if (@$row[$heading])
//                $arr[$heading] = $row[$heading];
//        }

        if (!$appointment) {
            return new Appointment($this->getHeadingsByTableColumns($row));
        }

    }



    public function getHeadingsByTableColumns(array $row){
        $tableName = 'appointments';
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);
        $orderedColumns = DB::select("SHOW COLUMNS FROM $tableName");
        $headings = [];

        foreach ($orderedColumns as $column) {
            if (in_array($column->Field, $columns)) {
                $headings[] = $column->Field;
            }
        }

        $arr = [];
        foreach ($headings as $heading){
            if (@$row[$heading])
                $arr[$heading] = $row[$heading];
        }
        return $arr;
    }
}
