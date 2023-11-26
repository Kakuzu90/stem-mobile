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
            <span class="fw-bolder">Duration:</span> {{ $sheet?->activity->timer ?? 'Not yet' }}
          </h5>
          <h5 class="text-dark">
            <span class="fw-bolder">End Time:</span> {{ $sheet?->end_time->format('H:i:s A') ?? 'Not yet' }}
          </h5>
        </div>
      </div>
    </div>
    <h3 class="text-dark mb-0">Test I. Enumeration</h3>
    <p class="text-muted">Direction: No direction</p>
    <div class="card">
      <div class="card-body">
        <h5 class="text-dark mb-0 fw-bold">What is your name?</h5>
        <p class="text-muted">Direction: No direction</p>
        <div class="d-flex justify-content-center align-items-center mb-1">
          <img src="{{ asset('images/placeholder.png') }}" class="img-fluid" alt="Placeholder Image" />
        </div>
        <h5 class="text-dark fw-bolder">Answer</h5>
        <div class="bg-light-success border border-success p-1 rounded align-items-center">
          Answer
        </div>
        <span>
          <i data-feather="check" class="font-medium-4 text-success"></i>
        </span>
        <h5 class="text-dark fw-bolder">Score</h5>
        <input type="text" class="form-control numerical" placeholder="Score" value="3"/>
      </div>
    </div>
  </div>
@endsection