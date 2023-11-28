@extends('layouts.teacher')

@section('title')
  @if (Session::get('status'))
    Welcome {{ auth()->user()->name }} to E-Learning Management System | E-LMS
  @else
  Students | E-LMS
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
              <h2 class="content-header-title float-start mb-0">Students</h2>
              <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                          <a href="javascript:void(;)">Users</a>
                      </li>
                      <li class="breadcrumb-item active">
                          Students
                      </li>
                  </ol>
              </div>
          </div>
      </div>
  </div>
</div>
<div class="content-body">
  <div class="card">
    <div class="card-header">
        <h4 class="card-title">
            List of Students
        </h4>
        <button type="button" class="btn btn-relief-primary" data-bs-toggle="modal" data-bs-target="#add">
            New Student
        </button>
    </div>
    <div class="table-responsive">
        <table class="table" id="init_datatable">
            <thead class="text-center">
                <tr>
                    <th>Student Name</th>
                    <th>Classrooms</th>
                    <th>Subjects</th>
                    <th>Actions</th>
                </tr>
            </thead>
                @foreach ($students as $item)
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
                        <td class="text-center">
                          @foreach ($item->student->classrooms as $classroom)
                              <span class="badge badge-pill bg-light-primary">
                                  <i data-feather="columns"></i>
                                  {{ $classroom->classroom_id }}
                              </span>
                          @endforeach
                        </td>
                        <td class="text-center">
                            @foreach ($item->student->subjects as $subject)
                                <span class="badge badge-pill bg-primary">
                                    {{ $subject->subject->name }}
                                </span>
                            @endforeach
                        </td>
                        <td class="text-center">
                          <button 
                              data-item-title="Edit <span class='text-primary'>{{ $item->student->fullname }}</span> Subjects"
                              data-item-route="{{ route('teacher.students.show', $item->student_id) }}"
                              data-bs-toggle="tooltip"
                              data-bs-placement="left"
                              title="Add Subjects"
                              type="button" 
                              class="edit btn btn-sm btn-icon btn-relief-success">
                              <i data-feather="edit"></i>
                          </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
        order:[[0, 'asc'], [1, 'asc']],
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

    $('#select2-ajax').wrap('<div class="position-relative"></div>').select2({
        dropdownAutoWidth: true,
        dropdownParent: $('#select2-ajax').parent(),
        width: '100%',
        ajax: {
            url: '{{ route('teacher.students.search') }}',
            data: function(params) {
                return {search : params.term}
            },
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        placeholder: 'Search a student last name here...',
        minimumInputLength: 1,
        escapeMarkup: function (markup) {
            return markup;
        },
        templateResult: templateResult,
        templateSelection: templateSelection
    });

    function templateResult(student) {
        if (student.loading) return student.text;
        return '<div class="d-flex align-items-center p-25">'+feather.icons['user'].toSvg({ class: 'me-50' }) + student.text+'</div>'
    }

    function templateSelection(student) {
        return '<div class="d-flex align-items-center">'+feather.icons['user'].toSvg({ class: 'me-50' }) + student.text+'</div>'
    }
    

    let uri = '';

    $('#add select[name=classroom]').on('change', function() {
        const uri = window.location.href;
        const newUri = uri.replace(/\/teacher\/students\/?/, "")
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

    $(document).on('click', '.edit', function() {
        const title = $(this).data('item-title')
        const route = $(this).data('item-route')
        uri = route
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

                $('#edit select[name=classroom]').val(response.classroom).trigger('change')

                $('#form-container').removeClass('d-none')
                $('#spinner').addClass('d-none')
                $('#form-container').addClass('d-block')
                $('#edit form').attr('action', route)
            }
        }); 
    });
    $('#edit select[name=classroom]').on('change', function() {
        $.ajax({
            url: uri + '/' + $(this).val(),
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#edit .subjects').empty()
                $('#edit .subjects').select2({data: response.option})
                $('#edit .subjects').val(response.subjects).trigger('change')
            }
        }); 
    });
</script>
@endsection