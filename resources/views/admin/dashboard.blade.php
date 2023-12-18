@extends('layouts.admin')

@section('title')
    @if (Session::get('status'))
        Welcome {{ auth()->user()->name }} to E-Learning Management System | E-LMS
    @else
        Dashboard | E-LMS
    @endif
@endsection

@section('body')
<div class="content-body">
    
    <div class="row">
        <div class="col-lg-4 col-md-6 col-12">
           <x-card.date />
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <x-card.user user="Teachers" :count="$data['teacher']" type="1" />
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <x-card.user user="Students" :count="$data['student']" type="2" />
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-4 col-12">
            <x-card.statistic title="School Year" :count="$data['year']" icon="calendar" color="bg-light-primary" />
        </div>
        <div class="col-lg-3 col-md-4 col-12">
            <x-card.statistic title="Grade Level" :count="$data['grade']" icon="bar-chart" color="bg-light-success" />
        </div>
        <div class="col-lg-3 col-md-4 col-12">
            <x-card.statistic title="Sections" :count="$data['section']" icon="briefcase" color="bg-light-warning" />
        </div>
        <div class="col-lg-3 col-md-4 col-12">
            <x-card.statistic title="Classrooms" :count="$data['classroom']"  icon="columns" color="bg-light-info" />
        </div>
        <div class="col-lg-3 col-md-4 col-12">
            <x-card.statistic title="Subjects" :count="$data['subject']" icon="layers" color="bg-light-danger" />
        </div>
        <div class="col-lg-3 col-md-4 col-12">
            <x-card.statistic title="Announcements" :count="$data['announcement']" icon="volume-2" color="bg-light-warning" />
        </div>
        <div class="col-lg-3 col-md-4 col-12">
            <x-card.statistic title="Quiz" :count="$data['quiz']" icon="edit" color="bg-light-success" />
        </div>
        <div class="col-lg-3 col-md-4 col-12">
            <x-card.statistic title="Assignments" :count="$data['assignment']" icon="edit" color="bg-light-primary" />
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Student Logs</h4>
            </div>
            <div class="table-responsive">
                <table class="table" id="init_datatable_students">
                    <thead class="text-center">
                        <tr>
                            <th>Student Name</th>
                            <th>Action</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['students'] as $item)
                            <tr>
                                <td class="text-left d-flex align-items-center">
                                    <div class="avatar">
                                        <img src="{{ $item->student->profile }}" alt="avatar" width="40" height="40" />
                                    </div>
                                    <div class="ms-50">
                                        <span class="fw-bolder">
                                            {{ $item->student->fullname }}
                                        </span>
                                        <small class="d-block">{{ $item->student->username }}</small>
                                    </div>   
                                </td>
                                <td>
                                    <span>{{ $item->action }}</span>
                                </td>
                                <td>
                                    <span>{{ $item->created_at->format('F d, Y') }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Student Logs</h4>
            </div>
            <div class="table-responsive">
                <table class="table" id="init_datatable_teachers">
                    <thead class="text-center">
                        <tr>
                            <th>Student Name</th>
                            <th>Action</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['teachers'] as $item)
                            <tr>
                                <td class="text-left d-flex align-items-center">
                                    <div class="avatar">
                                        <img src="{{ $item->teacher->profile }}" alt="avatar" width="40" height="40" />
                                    </div>
                                    <div class="ms-50">
                                        <span class="fw-bolder">
                                            {{ $item->teacher->fullname }}
                                        </span>
                                        <small class="d-block">{{ $item->teacher->username }}</small>
                                    </div>   
                                </td>
                                <td>
                                    <span>{{ $item->action }}</span>
                                </td>
                                <td>
                                    <span>{{ $item->created_at->format('F d, Y') }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
    <script>
        $('#init_datatable_students').DataTable({
            order:[[2, 'desc'],],
            language: {
                searchPlaceholder: "Search here..."
            },
            drawCallback: function() {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        });
        $('#init_datatable_students_wrapper div.row:first-child').addClass('px-2');
        $('#init_datatable_students_wrapper div.row:last-child').addClass('px-2');

        $('#init_datatable_teachers').DataTable({
            order:[[2, 'desc'],],
            language: {
                searchPlaceholder: "Search here..."
            },
            drawCallback: function() {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        });
        $('#init_datatable_teachers_wrapper div.row:first-child').addClass('px-2');
        $('#init_datatable_teachers_wrapper div.row:last-child').addClass('px-2');
        
    </script>
@endsection