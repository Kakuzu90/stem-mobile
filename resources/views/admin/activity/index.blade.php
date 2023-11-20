@extends('layouts.admin')

@section('title')
    @if (Session::get('status'))
        Welcome {{ auth()->user()->name }} to E-Learning Management System | STEM
    @else
        Activities | STEM
    @endif
@endsection

@section('body')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Activities</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(;)">Activities & Notifications</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Activities
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
                    List of Activities
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
                            <th>Classrooms</th>
                            <th>Subjects</th>
                            <th>Time</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activities as $item)
                            <tr>
                                <td>
                                    {{ $item->title }}
                                </td>
                                <td>
                                    @foreach ($item->classrooms as $classroom)
                                        <span class="badge badge-pill bg-light-primary">
                                            <i data-feather="columns"></i>
                                            {{ $classroom->classroom->title() }}
                                        </span>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($item->subjects as $subject)
                                        <span class="badge badge-pill bg-primary">
                                            {{ $subject->subject->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td>
                                    <span class="fw-bolder">{{ $item->timer }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-pill bg-{{ $item->type_color() }}">
                                        {{ $item->type() }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-pill bg-{{ $item->status_color() }}">
                                        {{ $item->status() }}
                                    </span>
                                </td>
                                <td>
                                    <div class="dropstart">
                                        <button 
                                            class="btn btn-sm btn-icon btn-round border-0 p-50 btn-relief-primary dropdown-toggle hide-arrow" 
                                            type="button" 
                                            data-bs-toggle="dropdown" 
                                            aria-haspopup="true" 
                                            aria-expanded="false">
                                            <i data-feather="settings"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" target="_blank" href="{{ route('admin.activities.questions', $item->id) }}">
                                                <i data-feather="file-text"></i> Results
                                            </a>
                                            <a class="dropdown-item" target="_blank" href="{{ route('admin.activities.questions', $item->id) }}">
                                                <i data-feather="file-plus"></i> Questions
                                            </a>
                                            <a 
                                                class="dropdown-item edit" href="javascript:void(;)"
                                                data-item-title="Edit <span class='text-primary'>{{ $item->title }}</span> Data"
                                                data-item-route="{{ route('admin.activities.show', $item->id) }}"
                                                >
                                                <i data-feather="edit"></i> Edit
                                            </a>
                                            <a 
                                                class="dropdown-item delete" href="javascript:void(;)"
                                                data-item-title="{{ $item->title }}"
                                                data-item-route="{{ route('admin.activities.show', $item->id) }}"
                                                >
                                                <i data-feather="trash-2"></i> Delete
                                            </a>
                                        </div>
                                    </div>
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
<script src="{{ asset('app-assets/vendors/js/forms/cleave/cleave.min.js') }}"></script>
<script>
    $('#init_datatable').DataTable({
        order:[[4, 'desc'], [5, 'desc'], [0, 'asc']],
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

    $('.time').each(function() {
        new Cleave(this, {
            time: true,
            timePattern: ['h', 'm', 's']
        })
    })

    $(document).on('change', 'input[name=publish]', function() {
        const is_check = $(this).prop('checked')
        if (is_check) {
            $(this).val(1)
        }else {
            $(this).val(2)
        }
    });

    $('#add select[name=classroom]').on('change', function() {
        const uri = window.location.href;
        const newUri = uri.replace(/\/activities\/?/, "")
        $.ajax({
            url: newUri + '/classrooms/' + $(this).val() +'/subjects',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#add .subjects').empty();
                $('#add .subjects').select2({data:response.subjects})
            }
        }); 
    });

    let uri = '';

    $('#edit select[name=classroom]').on('change', function() {
        $.ajax({
            url: uri + '/' + $(this).val() +'/subjects',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#edit .subjects').empty();
                $('#edit .subjects').select2({data:response.options})
                $('#edit .subjects').val(response.subjects).trigger('change')
            }
        }); 
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
        uri = route;
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
                $('#edit input[name=timer]').val(response.timer)
                if (response.publish == 1) {
                    $('#edit input[name=publish]').prop('checked', true)
                }else {
                    $('#edit input[name=publish]').prop('checked', false)
                }
                $('#edit input[name=publish]').val(response.publish)
                $('#edit select[name=type]').val(response.type).trigger('change')
                $('#edit select[name=classroom]').val(response.classroom).trigger('change')

                $('#form-container').removeClass('d-none')
                $('#spinner').addClass('d-none')
                $('#form-container').addClass('d-block')
                $('#edit form').attr('action', route)
            }
        }); 
    });
</script>
@endsection