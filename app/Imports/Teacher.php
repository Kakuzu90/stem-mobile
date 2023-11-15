<?php

namespace App\Imports;

use App\Models\Teacher as TeacherModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Teacher implements ToCollection, WithHeadingRow, SkipsOnFailure, SkipsOnError
{
    use SkipsErrors, SkipsFailures;
    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        foreach($rows as $row) {
            if (!TeacherModel::hasDuplicate(['first_name' => $row['first_name'], 'middle_name' => $row['middle_name'], 'last_name' => $row['last_name']])) {
                TeacherModel::create([
                    'first_name' => $row['first_name'],
                    'middle_name' => $row['middle_name'],
                    'last_name' => $row['last_name'],
                    'username' => $row['id_number'],
                    'password' => $row['password'],
                    'date_valid' => Carbon::now()->addYear(),
                ]);
            }
        }
    }

    public function headingRow(): int
    {
        return 2;
    }
}
