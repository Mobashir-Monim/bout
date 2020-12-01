@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-md"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark text-white">Select evaluation semester</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 my-1">
                            <select name="semester" id="semester" class="form-control">
                                @if (!isset(request()->semester))
                                    <option value="">Please select a semester</option>
                                    <option value="spring">Spring</option>
                                    <option value="summer">Summer</option>
                                    <option value="fall">Fall</option>
                                @else
                                    <option value="{{ request()->semester }}">{{ ucfirst(request()->semester) }}</option>
                                    @foreach (['spring', 'summer', 'fall'] as $item)
                                        @if (request()->semester != $item)
                                            <option value="{{ $item }}">{{ ucfirst($item) }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6 my-1">
                            <select name="year" id="year" class="form-control">
                                @if (isset(request()->year))
                                    <option value="{{ request()->year }}">{{ request()->year }}</option>
                                @else
                                    <option value="">Please select a year</option>
                                @endif
                                @for ($i = Carbon\Carbon::now()->diffInYears(Carbon\Carbon::parse('2020')); $i >= 0; $i--)
                                    @if (request()->year != $i + 2020)
                                        <option value="{{ 2020 + $i }}">{{ 2020 + $i }}</option>
                                    @endif
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 my-1">
                            <button class="btn btn-dark w-100">Comfirm</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md"></div>
    </div>

    <div class="row mb-4">
        <div class="col-md"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark text-white">Evaluation Results</div>
                <div class="card-body" id="eval-results">
                    <h5>Evaluation Results are not available</h5>
                </div>
            </div>
        </div>
        <div class="col-md"></div>
    </div>

    @if (auth()->user()->email == 'mobashir.monim@bracu.ac.bd' || auth()->user()->email == 'ext.mobashir.monim@bracu.ac.bd')
        <div class="row mb-4">
            <div class="col-md"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">Evaluation Configurations</div>
                    <div class="card-body text-center" id="eval-config">
                        <button onclick="configFactors()" class="btn btn-dark d-inline-block m-1">Configure Factors</button>
                        <button onclick="configMatrix()" class="btn btn-dark d-inline-block m-1">Configure Matrix</button>
                        <button onclick="evaluateCourses()" class="btn btn-dark d-inline-block m-1">Evaluate</button>
                    </div>
                </div>
            </div>
            <div class="col-md"></div>
        </div>
    @endif
@endsection

@section('scripts')
    @include('course-eval.scripts.index')
@endsection