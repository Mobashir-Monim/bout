@extends('layouts.dashboard')

@section('content')
    <form action="{{ route('offered-courses') }}" method="POST" id="run-confirm">
        @csrf
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <h5 class="mb-0 border-bottom">Select semester</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 col-12 my-1">
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
                            <div class="col-md-5 col-12 my-1">
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
                                <button class="btn btn-dark w-100"><i class="fas fa-check"></i></button>
                            </div>
                        </div>

                        @isset($helper)
                            @include('offered-course.actions.download')
                            @include('offered-course.actions.upload')
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </form>

    @isset($helper)
        @include('offered-course.show')
    @endisset
@endsection

@section('scripts')
    @isset($helper)
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.8/jszip.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.8/xlsx.min.js"></script>
        @include('offered-course.scripts.index')
        @include('offered-course.actions.scripts.download')
        @include('offered-course.actions.scripts.upload')
    @endisset
@endsection