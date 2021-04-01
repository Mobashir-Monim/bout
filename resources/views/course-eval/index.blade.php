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
                                        <button class="btn btn-dark w-100"><span class="material-icons-outlined" style="font-size: 1.2em">thumb_up_alt</span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

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

        @if (auth()->user()->email == 'mobashir.monim@bracu.ac.bd')
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body text-center" id="eval-config">
                            <h5 class="border-bottom text-left">Evaluation Configurations</h5>
                            <button onclick="configFactors()" class="btn btn-dark d-inline-block m-1">Configure Factors</button>
                            <button onclick="configMatrix()" class="btn btn-dark d-inline-block m-1">Configure Matrix</button>
                            <button onclick="evaluateCourses()" class="btn btn-dark d-inline-block m-1">Evaluate</button>
                            @if ($helper->isPublishable())
                                <form action="{{ route('eval-report.publish-toggle', ['year' => $helper->year, 'semester' => $helper->semester]) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-dark d-inline-block m-1">{{ !$helper->eval->is_published ? 'Publish' : 'Unpublish' }}</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif   
    @endif
@endsection

@section('scripts')
    @include('course-eval.scripts.index')
@endsection