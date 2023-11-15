@extends('layouts.admin')

@section('title')
    @if (Session::get('status'))
        Welcome {{ auth()->user()->name }} to E-Learning Management System | STEM
    @else
        School Year | STEM
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
                <h2 class="content-header-title float-start mb-0">School Year</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(;)">Informations</a>
                        </li>
                        <li class="breadcrumb-item active">
                            School Year
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
                    List of School Year
                </h4>
                <button type="button" class="btn btn-relief-primary" data-bs-toggle="modal" data-bs-target="#add">
                    Add New
                </button>
            </div>
            <div class="table-responsive">
                <table class="table text-center" id="init_datatable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Date From</th>
                            <th>Date To</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($years as $item)
                           <tr>
                                <td>
                                    <span class="badge bg-light-primary badge-pill">
                                        <i data-feather="clock"></i> {{ $item->id }}
                                    </span>
                                </td>
                                <td>
                                    {{ $item->name }}
                                </td>
                                <td>
                                    {{ $item->date_from->format('F d, Y') }}
                                </td>
                                <td>
                                    {{ $item->date_to->format('F d, Y') }}
                                </td>
                                <td>
                                    <span class="badge bg-light-{{ $item->status_color() }}">
                                        {{ $item->status() }}
                                    </span>
                                </td>
                                <td>
                                    <button 
                                        data-item-title="Edit <span class='text-primary'>{{ $item->name }}</span> Data"
                                        data-item-route="{{ route('admin.school-year.show', $item->id) }}"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="left"
                                        title="Edit {{ $item->name }}"
                                        type="button" 
                                        class="edit btn btn-sm btn-icon btn-relief-success">
                                        <i data-feather="edit"></i>
                                    </button>
                                    <button 
                                        data-item-title="{{ $item->name }}"
                                        data-item-route="{{ route('admin.school-year.show', $item->id) }}"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="left"
                                        title="Delete {{ $item->name }}"
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
        @error('name')
        toastr['error']('{{ $message }}', 'Duplicate Entry', {
            positionClass: 'toast-bottom-right',
            closeButton: true,
            tapToDismiss: false,
            progressBar: true,
            rtl: false
        });
        @enderror
        $('#init_datatable').DataTable({
            order:[[2, 'desc'], [3, 'desc'], [4, 'asc']],
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
                    $('#edit input[name=name]').val(response.name)
                    $('#edit input[name=date_from]').val(response.date_from)
                    $('#edit input[name=date_to]').val(response.date_to)

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