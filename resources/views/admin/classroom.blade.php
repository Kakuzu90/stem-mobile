@extends('layouts.admin')

@section('title')
    @if (Session::get('status'))
        Welcome {{ auth()->user()->name }} to E-Learning Management System | STEM
    @else
        Classrooms | STEM
    @endif
@endsection

@section('body')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Classrooms</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(;)">Informations</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Classrooms
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content-body">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    List of Classrooms
                </h4>
                <button type="button" class="btn btn-relief-primary" data-bs-toggle="modal" data-bs-target="#add">
                    Add New
                </button>
            </div>
            <div class="table-responsive">
                <table class="table" id="init_datatable">
                    <thead class="text-center">
                        <tr>
                            <th>No.</th>
                            <th>Teacher Name</th>
                            <th>Section</th>
                            <th>Grade Level</th>
                            <th>School Year</th>
                            <th>Subjects</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($classrooms as $item)
                            <tr>
                                <td class="text-center">
                                    <span class="badge bg-light-primary">
                                        <i data-feather="columns"></i> {{ $item->id }}
                                    </span>
                                </td>
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
                                <td class="text-center">
                                    {{ $item->section->name }}
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light-primary">
                                        <i data-feather="bar-chart"></i> {{ $item->section->grade_level->name }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    {{ $item->school_year->name }}
                                </td>
                                <td class="text-center">
                                    @foreach ($item->teacher_subjects as $subject)
                                    <span class="badge badge-pill bg-primary">
                                        {{ $subject->subject->name }}
                                    </span>
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    <button
                                        data-item-subjects="{{ route('admin.classrooms.show', $item->id) }}"
                                        data-item-route="{{ route('admin.classrooms.subject', $item->id) }}"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="left"
                                        title="Add Subjects"
                                        type="button"
                                        class="subject btn btn-sm btn-icon btn-relief-primary">
                                        <i data-feather="file-plus"></i>
                                    </button>
                                    <button 
                                        data-item-title="Edit <span class='text-primary'>{{ $item->title() }}</span> Data"
                                        data-item-route="{{ route('admin.classrooms.show', $item->id) }}"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="left"
                                        title="Edit {{ $item->title() }}"
                                        type="button" 
                                        class="edit btn btn-sm btn-icon btn-relief-success">
                                        <i data-feather="edit"></i>
                                    </button>
                                    <button 
                                        data-item-title="{{ $item->title() }}"
                                        data-item-route="{{ route('admin.classrooms.show', $item->id) }}"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="left"
                                        title="Delete {{ $item->title() }}"
                                        type="button" 
                                        class="delete btn btn-sm btn-icon btn-relief-danger">
                                        <i data-feather="delete"></i>
                                    </button>
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
    <script src="{{ asset('app-assets/js/scripts/forms/form-select2.js') }}"></script>
    <script>
        $('#init_datatable').DataTable({
            order: [[5, 'desc'], [4, 'desc'], [3, 'asc'], [2, 'asc'], [1, 'asc']],
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
        $('#init_datatable_wrapper div.row:first-child').addClass('px-2');
        $('#init_datatable_wrapper div.row:last-child').addClass('px-2');
        $('select[name=init_datatable_length]').select2({
            minimumResultsForSearch: Infinity,
        });

        $(document).on('click', '.delete', function() {
            const route = $(this).data('item-route')
            const title = $(this).data('item-title')
            $('#delete form').attr('action', route)
            $('#delete .item-to-delete').text(title)
            $('#delete').modal('show')
        });

        $(document).on('click', '.edit', function() {
            const route = $(this).data('item-route')
            const title = $(this).data('item-title')
            $('#edit .modal-title').html(title)
            $('#edit').modal('show')
            $('#edit #spinner').removeClass('d-none')
            $('#edit #form-container').addClass('d-none')
            $('#edit #form-container').removeClass('d-block')
            $.ajax({
                url: route,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#edit select[name=teacher]').val(response.teacher).trigger('change')
                    $('#edit select[name=section]').val(response.section).trigger('change')
                    $('#edit select[name=year]').val(response.year).trigger('change')

                    $('#edit #form-container').removeClass('d-none')
                    $('#edit #spinner').addClass('d-none')
                    $('#edit #form-container').addClass('d-block')
                    $('#edit form').attr('action', route)
                }
            }); 
        });

        $(document).on('click', '.subject', function() {
            const route = $(this).data('item-route')
            const subjectRoute = $(this).data('item-subjects')
            $('#subject #spinner').removeClass('d-none')
            $('#subject #form-container').addClass('d-none')
            $('#subject #form-container').removeClass('d-block')
            $('#subject').modal('show')
            $.ajax({
                url: subjectRoute,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#subject select').val(response.subjects).trigger('change')

                    $('#subject #form-container').removeClass('d-none')
                    $('#subject #spinner').addClass('d-none')
                    $('#subject #form-container').addClass('d-block')
                    $('#subject form').attr('action', route)
                }
            }); 
        });
        
    </script>
@endsection