@extends('layouts.admin')

@section('title')
    @if (Session::get('status'))
        Welcome {{ auth()->user()->name }} to E-Learning Management System | E-LMS
    @else
        Teachers | E-LMS
    @endif
@endsection

@section('plugin')
    <link rel="stylesheet" href="{{ asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app-assets/css/plugins/forms/pickers/form-flat-pickr.css') }}">
@endsection

@section('body')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Teachers</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(;)">Users</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Teachers
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content-body">
    <div class="row justify-content-center align-items-center">
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bolder mb-75">{{ $statistics['expired'] }}</h3>
                        <span>Expired Teachers</span>
                    </div>
                    <div class="avatar bg-light-danger p-50">
                        <span class="avatar-content">
                            <i data-feather="user-x" class="font-medium-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bolder mb-75">{{ $statistics['active'] }}</h3>
                        <span>Active Teachers</span>
                    </div>
                    <div class="avatar bg-light-success p-50">
                        <span class="avatar-content">
                            <i data-feather="user-check" class="font-medium-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    List of Teachers
                </h4>
                <div>
                    <a 
                        data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        title="Download Excel Template"
                        href="{{ route('admin.template.teacher') }}" 
                        class="btn btn-relief-dark">
                        <i data-feather="download"></i>
                    </a>
                    <button 
                        type="button" 
                        class="upload btn btn-relief-info"
                        data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        title="Upload Excel Data">
                        <i data-feather="upload"></i>
                    </button>
                    <button type="button" class="btn btn-relief-primary" data-bs-toggle="modal" data-bs-target="#add">
                        Add New
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table" id="init_datatable">
                    <thead class="text-center">
                        <tr>
                            <th>Teacher Name</th>
                            <th>Classrooms</th>
                            <th>Subjects</th>
                            <th>Date Valid</th>
                            <th>Date Added</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                        @foreach ($teachers as $item)
                            <tr>
                                <td class="text-left d-flex align-items-center">
                                    <div class="avatar">
                                        <img src="{{ $item->profile }}" alt="avatar" width="40" height="40" />
                                    </div>
                                    <div class="ms-50">
                                        <span class="fw-bolder">
                                            {{ $item->fullname }}
                                        </span>
                                        <small class="d-block">{{ $item->username }}</small>
                                    </div>   
                                </td>
                                <td class="text-center">
                                    @foreach ($item->classrooms as $classroom)
                                        <span class="badge badge-pill bg-light-primary">
                                            <i data-feather="columns"></i>
                                            {{ $classroom->classroom_id }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    @foreach ($item->subjects as $subject)
                                        <span class="badge badge-pill bg-primary">
                                            {{ $subject->subject->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="{{ $item->isExpired() }} text-center">
                                    {{ $item->date_valid->format('F d, Y') }}
                                </td>
                                <td class="text-center">
                                    {{ $item->created_at->format('F d, Y') }}
                                </td>
                                <td class="text-center">
                                    <button 
                                        data-item-title="Edit <span class='text-primary'>{{ $item->fullname }}</span> Data"
                                        data-item-route="{{ route('admin.teachers.show', $item->id) }}"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="left"
                                        title="Edit {{ $item->fullname }}"
                                        type="button" 
                                        class="edit btn btn-sm btn-icon btn-relief-success">
                                        <i data-feather="edit"></i>
                                    </button>
                                    <button 
                                        data-item-title="{{ $item->fullname }}"
                                        data-item-route="{{ route('admin.teachers.show', $item->id) }}"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="left"
                                        title="Delete {{ $item->fullname }}"
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
    <script src="{{ asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
    <script>
        $('#init_datatable').DataTable({
            order: [[3, 'desc'], [0, 'asc']],
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

        $('.flatpickr-human-friendly').flatpickr({
            altInput: true,
            altFormat: 'F j, Y',
            dateFormat: 'Y-m-d'
        });

        @error('file')
        toastr['error']('{{ $message }}', 'Invalid File', {
            positionClass: 'toast-bottom-right',
            closeButton: true,
            tapToDismiss: false,
            progressBar: true,
            rtl: false
        });
        @enderror

        $(document).on('click', '.upload', function() {
            $('#upload').modal('show')
        });

        $(document).on('click', '.delete', function() {
            const route = $(this).data('item-route')
            const title = $(this).data('item-title')
            $('#delete form').attr('action', route)
            $('#delete .item-to-delete').text(title)
            $('#delete').modal('show')
        });

        $(document).on('click', '.edit', function() {
            const title = $(this).data('item-title')
            const route = $(this).data('item-route')
            $('#edit .modal-title').html(title)
            $('#edit').modal('show')
            $('#spinner').removeClass('d-none')
            $('#form-container').addClass('d-none')
            $('#form-container').removeClass('d-block')
            $.ajax({
                url: route,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#edit input[name=first_name]').val(response.first_name)
                    $('#edit input[name=middle_name]').val(response.middle_name)
                    $('#edit input[name=last_name]').val(response.last_name)
                    $('#edit input[name=username]').val(response.username)
                    $('#edit input[name=date_valid]').val(response.date_valid)

                    $('.flatpickr-human-friendly').flatpickr({
                        altInput: true,
                        altFormat: 'F j, Y',
                        dateFormat: 'Y-m-d'
                    });

                    $('#form-container').removeClass('d-none')
                    $('#spinner').addClass('d-none')
                    $('#form-container').addClass('d-block')
                    $('#edit form').attr('action', route)
                }
            }); 
        });
    </script>
@endsection