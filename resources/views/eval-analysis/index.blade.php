@extends('layouts.dashboard')

@section('content')
    <h5 class="border-bottom">Evaluation Distribution</h5>
    <form action="{{ route('eval-analysis') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-4 my-2">
                <select name="dist_type" class="form-control" id="dist_type">
                    @if (!isset($helper))
                        <option value="">Please select an distribution type</option>
                        <option value="dept-comparison">Department Scores Distribution</option>
                        <option value="course-overall-score-distribution">Course Score Distribution</option>
                        <option value="section-score-distribution">Section Score Distribution</option>
                    @else
                        @foreach ($helper->getDistTypes() as $dist_type => $type)
                            <option value="{{ $dist_type }}">{{ $type }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-3 my-2">
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
            <div class="col-md-3 my-2">
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
            <div class="col-md-2 my-2">
                <select name="chart_type" id="chart_type" class="form-control">
                    @if (isset($helper))
                        <option value="{{ $helper->chart_type }}">{{ ucfirst($helper->chart_type) }}</option>
                        @foreach (['radar', 'line', 'bar'] as $chart_type)
                            @if ($helper->chart_type != $chart_type)
                                <option value="{{ $chart_type }}">{{ ucfirst($chart_type) }}</option>
                            @endif
                        @endforeach
                    @else
                        <option value="">Chart Type</option>
                        @foreach (['radar', 'line', 'bar'] as $chart_type)
                            <option value="{{ $chart_type }}">{{ ucfirst($chart_type) }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 my-2 offset-md-10">
                <button class="btn btn-dark w-100">Get Distribution</button>
            </div>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.2.0/dist/chart.min.js"></script>
    @isset($helper)
        @include($helper->dist_view)
    @endisset
@endsection