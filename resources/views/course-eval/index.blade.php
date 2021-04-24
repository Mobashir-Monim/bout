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
                @if (auth()->user()->isHead)
                    <div class="col-md-4 my-2">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('eval-analysis') }}" class="btn btn-dark w-100 my-2"><span class="material-icons-outlined">insights</span> Evaluation Analytics</a>
                                @if (auth()->user()->email == 'mobashir.monim@bracu.ac.bd')
                                    <a href="{{ route('eval-analysis.create') }}" class="btn btn-dark w-100 my-2"><span class="material-icons-outlined">filter_list</span> Create Filters</a>
                                    <a href="#" class="btn btn-dark w-100 my-2"><span class="material-icons-outlined">account_tree</span> Collect Filter data</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
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