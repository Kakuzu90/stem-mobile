@extends('layouts.teacher')

@section('title')
  @if (Session::get('status'))
    Welcome {{ auth()->guard('teacher')->user()->fullname }} to E-Learning Management System | E-LMS
  @else
    Announcements | E-LMS
  @endif
@endsection

@section('link_vendor')
<link rel="stylesheet" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
<link rel="stylesheet" href="{{ asset('app-assets/css/plugins/forms/pickers/form-flat-pickr.css') }}">
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
                          <a href="javascript:void(;)">Notifications</a>
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
                          <th>Date Open</th>
                          <th>Date Closed</th>
                          <th>Status</th>
                          <th>Actions</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($announcements as $item)
                          <tr>
                              <td>
                                  {{ $item->announcement->title }}
                              </td>
                              <td>{{ $item->announcement->context }}</td>
                              <td>
                                  @foreach ($item->announcement->classrooms as $classroom)
                                  <span class="text-dark font-small-2 d-block border border-dark p-25 m-25 rounded">
                                    {{ $classroom->classroom->title() }}
                                  </span>
                                  @endforeach
                              </td>
                              <td>
                                <span class="text-primary font-small-3">{{ $item->announcement->date_open->format('F d, Y') }}</span>
                                </td>
                                <td>
                                    <span class="text-primary font-small-3">{{ $item->announcement->date_closed->format('F d, Y') }}</span>
                                </td>
                              <td>
                                  <span class="badge badge-pill bg-{{ $item->announcement->status_color() }}">
                                      {{ $item->announcement->status() }}
                                  </span>
                              </td>
                              <td>
                                  <button 
                                      data-item-title="Edit <span class='text-primary'>{{ $item->announcement->title }}</span> Data"
                                      data-item-route="{{ route('teacher.announcements.show', $item->announcement_id) }}"
                                      data-bs-toggle="tooltip"
                                      data-bs-placement="left"
                                      title="Edit {{ $item->announcement->title }}"
                                      type="button" 
                                      class="edit btn btn-sm btn-icon btn-relief-success">
                                      <i data-feather="edit"></i>
                                  </button>
                                  <button 
                                      data-item-title="{{ $item->announcement->title }}"
                                      data-item-route="{{ route('teacher.announcements.show', $item->announcement_id) }}"
                                      data-bs-toggle="tooltip"
                                      data-bs-placement="left"
                                      title="Delete {{ $item->announcement->title }}"
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

@section('script_vendor')
<script src="{{ asset('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
@endsection

@section('scripts')
  <script src="{{ asset('app-assets/js/scripts/forms/form-select2.js') }}"></script>
  <script src="{{ asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
  <script>
      $('#init_datatable').DataTable({
        order:[[3, 'desc'], [4, 'desc'], [5, 'desc']],
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
                    $('#edit input[name=date_open]').val(response.date_open)
                    $('#edit input[name=date_closed]').val(response.date_closed)

                    $('.flatpickr-human-friendly').flatpickr({
                        altInput: true,
                        altFormat: 'F j, Y',
                        dateFormat: 'Y-m-d'
                    });
                    
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