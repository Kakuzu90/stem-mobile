@extends('layouts.empty')

@section('title')
  {{ $student->fullname }} Result | E-LMS
@endsection

@section('content')
  <div class="content-body p-2">
    <div class="card">
      <div class="card-body">
        <h5 class="text-dark">
          <span class="fw-bolder">Title:</span> {{ $sheet?->activity->title ?? 'Not yet' }}
        </h5>
        <div class="d-flex justify-content-between align-items-center">
          <h5 class="text-dark">
            <span class="fw-bolder">Type:</span> {{ $sheet?->activity->type() ?? 'Not yet' }}
          </h5>
          <h5 class="text-dark">
            <span class="fw-bolder">Date Submitted:</span> {{ $sheet?->created_at->format('F d, Y') ?? 'Not yet' }}
          </h5>
        </div>
        <div class="d-flex justify-content-between align-items-center">
          <h5 class="text-dark">
            <span class="fw-bolder">Subject:</span> {{ $sheet?->subject->name ?? 'No subject' }}
          </h5>
          <h5 class="text-dark">
            <span class="fw-bolder">Start Time:</span> {{ $sheet?->start_time->format('H:i:s A') ?? 'Not yet' }}
          </h5>
        </div>
        <div class="d-flex justify-content-between align-items-center">
          <h5 class="text-dark">
            <span class="fw-bolder">Duration:</span> {{ $sheet?->activity->timer() ?? 'Not yet' }}
          </h5>
          <h5 class="text-dark">
            <span class="fw-bolder">End Time:</span> {{ $sheet?->end_time->format('H:i:s A') ?? 'Not yet' }}
          </h5>
        </div>
      </div>
    </div>
  <form action="{{ route('admin.activities.answer', [$activity->id, $student->id, $classroom->id, $subject->id]) }}" method="POST">
    @csrf
    @method('PUT')
    @foreach ($activity->activity_sections as $section)
    <h3 class="text-dark">{{ $section->title }}</h3>
    @if ($section->direction)
    <p class="text-muted">Direction: {{ $section->direction }}</p>
    @endif
      @foreach ($section->questions as $question)
      <div class="card">
        <div class="card-body">
          <h5 class="text-dark fw-bolder">{{ $question->question }}</h5>
          @if ($question->direction)
          <p class="text-muted">Direction: {{ $question->direction }}</p>
          @endif
          @if ($question->with_image_path)
          <div class="d-flex justify-content-center align-items-center mb-1">
            <img src="{{ route('api.admin.image', $question->with_image_path) }}" class="img-fluid" alt="Placeholder Image" />
          </div>
          @endif
          <h5 class="text-danger fw-bolder">Answer</h5>
          @php
            $answer = studentAnswer($sheet, $question);
          @endphp
          @if ($answer->with_image_path)
          <div class="d-flex justify-content-center align-items-center flex-column mb-25">
            @foreach (json_decode($answer->with_image_path) as $image)
            <img 
              src="{{ route('api.admin.answer', $image) }}" 
              class="img-fluid rounded cursor-pointer open-img"
              data-item-src="{{ route('api.admin.answer', $image) }}" 
              alt="Placeholder Image"
            />
            @endforeach
          </div>
          @else
          <div class="bg-light-{{ $answer->answer_color() }} border border-{{ $answer->answer_color() }} p-1 rounded align-items-center mb-25">
            {{ $answer->answer }}
          </div> 
          @endif
          <span>
            <i data-feather="{{ $answer->answer_icon() }}" class="font-medium-4 text-{{ $answer->answer_color() }}"></i>
          </span>
          <h5 class="text-dark fw-bolder mt-25">Score</h5>
          <input type="text" class="form-control numerical" name="answer-{{ $answer->id }}" placeholder="Score" value="{{ $answer->score }}"/>
        </div>
      </div>
      @endforeach
    @endforeach
    <div class="d-flex justify-content-center align-items-center">
      <button type="submit" class="btn btn-relief-warning">
        <i data-feather="save" class="me-25"></i> Update Answer Sheet
      </button>
    </div>
  </form>
    <div class="modal fade" id="modal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <img src="{{ asset('images/placeholder.png') }}" class="img-fluid" />
          </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script>
    $(document).on('click', '.open-img', function() {
      const src = $(this).data('item-src');
      $('#modal').modal('show');
      $('#modal img').attr('src', src)
    })
    @if ($message = Session::get('success'))
      toastr['success']('{{ $message[1] }}', '{{ $message[0] }}', {
          positionClass: 'toast-bottom-right',
          closeButton: true,
          tapToDismiss: false,
          progressBar: true,
          rtl: false
      });
    @endif
  </script>
@endsection