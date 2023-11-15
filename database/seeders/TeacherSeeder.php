<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Teacher::create([
            'first_name' => 'Lorem',
            'middle_name' => 'Doe',
            'last_name' => 'John',
            'username' => '202300123',
            'password' => 'password',
            'date_valid' => Carbon::now()->addYear(),
        ]);
    }
}
