<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Student::create([
            'first_name' => 'John',
            'middle_name' => 'Lorem',
            'last_name' => 'Doe',
            'age' => '20',
            'address' => 'Address here...',
            'username' => '202300123',
            'password' => 'password',
            'date_valid' => Carbon::now()->addYear(),
        ]);
    }
}
