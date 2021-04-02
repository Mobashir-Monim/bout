@extends('layouts.dashboard')

@section('content')
    <form action="{{ route('course-eval.semester-confirm') }}" method="POST">
        @csrf
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="border-bottom">Select evaluation semester</h5>
                                    </div>
                                    <div class="col-md-5 my-1">
                                        <select name="semester" id="semester" class="form-control">
                                            @if (!isset($helper))
                                                <option value="">Please select a semester</option>
                                                <option value="spring">Spring</option>
                                                <option value="summer">Summer</option>
                                                <option value="fall">Fall</option>
                                            @else
                                                <option value="{{ $helper->semester }}">{{ ucfirst($helper->semester) }}</option>
                                                @foreach (['spring', 'summer', 'fall'] as $item)
                                                    @if ($helper->semester != $item)
                                                        <option value="{{ $item }}">{{ ucfirst($item) }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-5 my-1">
                                        <select name="year" id="year" class="form-control">
                                            @if (isset($helper))
                                                <option value="{{ $helper->year }}">{{ $helper->year }}</option>
                                                @for ($i = Carbon\Carbon::now()->diffInYears(Carbon\Carbon::parse('1st Jan 2020')); $i >= 0; $i--)
                                                    @if ($helper->year != $i + 2020)
                                                        <option value="{{ 2020 + $i }}">{{ 2020 + $i }}</option>
                                                    @endif
                                                @endfor
                                            @else
                                                <option value="">Please select a year</option>
                                                @for ($i = Carbon\Carbon::now()->diffInYears(Carbon\Carbon::parse('1st Jan 2020')); $i >= 0; $i--)
                                                    <option value="{{ 2020 + $i }}">{{ 2020 + $i }}</option>
                                                @endfor
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-2 my-1">
                                        <button class="btn btn-dark w-100"><span class="material-icons-outlined" style="font-size: 1.2em">check</span></button>
                                    </div>
                                    @if (auth()->user()->email == 'mobashir.monim@bracu.ac.bd' && isset($helper))
                                        <div class="col-md-12 my-2 mt-4">
                                            <h5 class="border-bottom text-left">Evaluation Configurations</h5>
                                            <button onclick="configFactors()" type="button" class="btn btn-dark d-inline-block m-1">Factors</button>
                                            <button onclick="configMatrix()" type="button" class="btn btn-dark d-inline-block m-1">Matrix</button>
                                            <button onclick="evaluateCourses()" type="button" class="btn btn-dark d-inline-block m-1">Evaluate</button>
                                            @if ($helper->isPublishable())
                                                <button type="button" onclick="toggleEvalPublish()" class="btn btn-dark d-inline-block m-1">{{ !$helper->eval->is_published ? 'Publish' : 'Unpublish' }}</button>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @if (auth()->user()->email == 'mobashir.monim@bracu.ac.bd' && isset($helper))
        @if ($helper->isPublishable())
            <form action="{{ route('eval-report.publish-toggle', ['year' => $helper->year, 'semester' => $helper->semester]) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="hidden" id="publish-btn">{{ !$helper->eval->is_published ? 'Publish' : 'Unpublish' }}</button>
            </form>
        @endif
    @endif

    @if (isset($helper))
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body" id="eval-results">
                        <h5 class="border-bottom">Evaluation Results</h5>
                        @if ($helper->isReportable() && sizeof($helper->results) != 0)
                            @if ($helper->data['type'] == 'reports')
                                @include('course-eval.reports.available')
                            @else
                                @include('course-eval.reports.filter')
                            @endif
                        @else
                            <h5>Evaluation Results are not available</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    @include('course-eval.scripts.index')
@endsection