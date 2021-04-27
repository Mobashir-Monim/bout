@extends('layouts.dashboard')

@section('content')
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-8 my-2">
                    <div class="card">
                        <div class="card-body">
                            @include('course-eval.parts.semester-select')
                            @include('course-eval.parts.eval-configs')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('course-eval.parts.eval-copy')
    @include('course-eval.parts.eval-box')
    @include('course-eval.parts.eval-score-formula.index')

@endsection

@section('scripts')
    @include('course-eval.scripts.index')
@endsection