@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="border-bottom">Tracker Semester</h5>
                    <form action="{{ route('eval-tracker.store') }}" method="post" id="tracker-form">
                        @csrf
                        <input type="hidden" name="trackers" id="trackers">
                        <div class="row">
                            <div class="col-md-6 my-2">
                                <select name="semester" id="semester" class="form-control" required>
                                    <option value="">Semester</option>
                                    <option value="Spring">Spring</option>
                                    <option value="Summer">Summer</option>
                                    <option value="Fall">Fall</option>
                                </select>
                            </div>
                            <div class="col-md-6 my-2">
                                <input type="number" step="1" min="2022" name="year" id="year" class="form-control" placeholder="Year" required>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12" id="meta-cont">
            <div class="card my-3" id="tracker-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 ml-auto">
                            <button class="btn btn-dark w-100" type="button" onclick="deleteTracker(0)">Delete Tracker</button>
                        </div>
                        <div class="col-md-12">
                            <select name="dept" id="dept-0" class="form-control my-3">
                                <option value="">Department/Institute</option>
                                @foreach ($providers as $provider)
                                    <option value="{{ $provider }}">{{ $provider }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5 class="border-bottom my-3">Theory Response Details</h6>
                            <input type="text" id="theory-response-0" class="form-control my-1" placeholder="Response Google Sheet">
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="text" id="theory-email-0" class="form-control my-1" placeholder="Email Address Header">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" id="theory-email-range-0" class="form-control my-1" placeholder="Email Range">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="text" id="theory-course-0" class="form-control my-1" placeholder="Course Code Header">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" id="theory-course-range-0" class="form-control my-1" placeholder="Code Range">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="text" id="theory-section-0" class="form-control my-1" placeholder="Section Header">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" id="theory-section-range-0" class="form-control my-1" placeholder="Section Range">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5 class="border-bottom my-3">Lab Response Details</h6>
                            <input type="text" id="lab-response-0" class="form-control my-1" placeholder="Response Google Sheet">
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="text" id="lab-email-0" class="form-control my-1" placeholder="Email Address Header">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" id="lab-email-range-0" class="form-control my-1" placeholder="Email Range">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="text" id="lab-course-0" class="form-control my-1" placeholder="Course Code Header">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" id="lab-course-range-0" class="form-control my-1" placeholder="Code Range">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="text" id="lab-section-0" class="form-control my-1" placeholder="Section Header">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" id="lab-section-range-0" class="form-control my-1" placeholder="Section Range">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md"></div>
        <div class="col-md-3 my-5">
            <button class="btn btn-dark w-100" type="button" onclick="appendTracker()">Add Tracker</button>
        </div>
        <div class="col-md-3 my-5">
            <button class="btn btn-dark w-100" type="button" onclick="collateTrackers()">Create Tracker(s)</button>
        </div>
    </div>
@endsection

@section('scripts')
    @include('course-eval.tracker.scripts.create')
@endsection