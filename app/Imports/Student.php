<?php

namespace App\Imports;

use App\Models\Student as ModelsStudent;
use App\Models\StudentSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Student implements ToCollection, WithHeadingRow, SkipsOnError, SkipsOnFailure
{
    use SkipsErrors, SkipsFailures;

    public $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }
    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        foreach($rows as $row) {
            if (!ModelsStudent::hasDuplicate(['first_name' => $row['first_name'], 'middle_name' => $row['middle_name'], 'last_name' => $row['last_name']])) {
                $student = ModelsStudent::create([
                    'first_name' => $row['first_name'],
                    'middle_name' => $row['middle_name'],
                    'last_name' => $row['last_name'],
                    'username' => $row['id_number'],
                    'password' => $row['password'],
                    'age' => $row['age'],
                    'address' => $row['address'],
                    'date_valid' => Carbon::now()->addYear(),
                ]);

                foreach($this->request->subjects as $subject) {
                    StudentSubject::create([
                        'student_id' => $student->id,
                        'classroom_id' => $this->request->classroom,
                        'subject_id' => $subject,
                    ]);
                }
            }
        }
    }

    public function headingRow(): int
    {
        return 2;
    }
}
