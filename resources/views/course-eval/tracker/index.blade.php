@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @include('course-eval.tracker.parts.semester-select')
                </div>
            </div>
        </div>
    </div>
    

    @include('course-eval.tracker.parts.trackers')

    @isset($helper)
        @include('course-eval.tracker.parts.courses')
        @include('course-eval.tracker.parts.student-list')
    @endisset
@endsection

@section('scripts')
    @include('course-eval.tracker.scripts.index')
@endsection