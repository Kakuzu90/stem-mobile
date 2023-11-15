@extends('layouts.admin')

@section('title')
    @if (Session::get('status'))
        Welcome {{ auth()->user()->name }} to E-Learning Management System | STEM
    @else
        Announcements | STEM
    @endif
@endsection

@section('body')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Announcements</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(;)">Activities & Notifications</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Announcements
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
                    List of Announcements
                </h4>
                <button type="button" class="btn btn-relief-primary" data-bs-toggle="modal" data-bs-target="#add">
                    Add New
                </button>
            </div>
            <div class="table-responsive">
                <table class="table text-center" id="init_datatable">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Context</th>
                            <th>Classrooms</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($announcements as $item)
                            <tr>
                                <td>
                                    {{ $item->title }}
                                </td>
                                <td>{{ $item->context }}</td>
                                <td>
                                    @foreach ($item->classrooms as $classroom)
                                        <span class="badge badge-pill bg-light-primary">
                                            <i data-feather="columns"></i>
                                            {{ $classroom->classroom->title() }}
                                        </span>
                                    @endforeach
                                </td>
                                <td>
                                    <span class="badge badge-pill bg-{{ $item->status_color() }}">
                                        {{ $item->status() }}
                                    </span>
                                </td>
                                <td>
                                    <button 
                                        data-item-title="Edit <span class='text-primary'>{{ $item->title }}</span> Data"
                                        data-item-route="{{ route('admin.announcements.show', $item->id) }}"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="left"
                                        title="Edit {{ $item->title }}"
                                        type="button" 
                                        class="edit btn btn-sm btn-icon btn-relief-success">
                                        <i data-feather="edit"></i>
                                    </button>
                                    <button 
                                        data-item-title="{{ $item->title }}"
                                        data-item-route="{{ route('admin.announcements.show', $item->id) }}"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="left"
                                        title="Delete {{ $item->title }}"
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
            order:[[3, 'desc'], [0, 'asc']],
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

        $(document).on('change', 'input[name=publish]', function() {
            const is_check = $(this).prop('checked')
            if (is_check) {
                $(this).val(1)
            }else {
                $(this).val(2)
            }
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
                    
                    $('#edit input[name=title]').val(response.title)
                    $('#edit textarea[name=context]').val(response.context)
                    if (response.publish == 1) {
                        $('#edit input[name=publish]').prop('checked', true)
                    }else {
                        $('#edit input[name=publish]').prop('checked', false)
                    }
                    $('#edit input[name=publish]').val(response.publish)
                    $('#edit select').val(response.classrooms).trigger('change')

                    $('#form-container').removeClass('d-none')
                    $('#spinner').addClass('d-none')
                    $('#form-container').addClass('d-block')
                    $('#edit form').attr('action', route)
                }
            }); 
        });
    </script>
@endsection