@extends('layouts.teacher')

@section('title')
  @if (Session::get('status'))
    Welcome {{ auth()->user()->name }} to E-Learning Management System | STEM
  @else
    Modules | STEM
  @endif
@endsection

@section('link_vendor')
<link rel="stylesheet" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css') }}">
@endsection

@section('body')
<div class="content-header row">
  <div class="content-header-left col-md-9 col-12 mb-2">
      <div class="row breadcrumbs-top">
          <div class="col-12">
              <h2 class="content-header-title float-start mb-0">Modules</h2>
              <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                          <a href="javascript:void(;)">Activities</a>
                      </li>
                      <li class="breadcrumb-item active">
                          Modules
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
                  List of Modules
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
                          <th>Status</th>
                          <th>Actions</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($modules as $item)
                          <tr>
                              <td>
                                  {{ $item->module->title }}
                              </td>
                              <td>
                                  @foreach ($item->module->classrooms as $classroom)
                                      <span class="badge badge-pill bg-light-primary">
                                          {{ $classroom->classroom->title() }}
                                      </span>
                                  @endforeach
                              </td>
                              <td>
                                  @foreach ($item->module->subjects as $subject)
                                      <span class="badge badge-pill bg-primary">
                                          {{ $subject->subject->name }}
                                      </span>
                                  @endforeach
                              </td>
                              <td>
                                  <span class="badge badge-pill bg-{{ $item->module->status_color() }}">
                                      {{ $item->module->status() }}
                                  </span>
                              </td>
                              <td>
                                  <button 
                                      data-item-title="Edit <span class='text-primary'>{{ $item->module->fullname }}</span> Data"
                                      data-item-route="{{ route('teacher.modules.show', $item->module_id) }}"
                                      data-bs-toggle="tooltip"
                                      data-bs-placement="left"
                                      title="Edit {{ $item->module->title }}"
                                      type="button" 
                                      class="edit btn btn-sm btn-icon btn-relief-success">
                                      <i data-feather="edit"></i>
                                  </button>
                                  <button 
                                      data-item-title="{{ $item->module->title }}"
                                      data-item-route="{{ route('teacher.modules.show', $item->module_id) }}"
                                      data-bs-toggle="tooltip"
                                      data-bs-placement="left"
                                      title="Delete {{ $item->module->title }}"
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

        $('#add select[name=classroom]').on('change', function() {
            const uri = window.location.href;
            const newUri = uri.replace(/\/teacher\/modules\/?/, "")
            console.log(newUri)
            $.ajax({
                url: newUri + '/api/teacher/classrooms/' + $(this).val() +'/subjects',
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
                    if (response.publish == 1) {
                        $('#edit input[name=publish]').prop('checked', true)
                    }else {
                        $('#edit input[name=publish]').prop('checked', false)
                    }
                    $('#edit input[name=publish]').val(response.publish)
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