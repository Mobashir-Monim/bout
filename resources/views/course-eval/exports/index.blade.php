@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-body">
                    <h4 class="border-bottom">Export Target</h4>
                    
                    <div class="row">
                        <div class="col-md-5 my-2">
                            <input type="text" name="semester" class="form-control" placeholder="Semester" value="Summer" id="semester">
                        </div>
                        <div class="col-md-5 my-2">
                            <input type="text" name="year" class="form-control" placeholder="Year" value="2020" id="year">
                        </div>
                        <div class="col-md my-2">
                            <button class="btn btn-dark w-100" type="button" onclick="exportEval()">Export</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card my-5">
                <div class="card-body">
                    <h4 class="border-bottom">Export Stats</h4>
                    <div class="row">
                        <div class="col-md-6 my-2">
                            <h5 class="border-bottom my-4">Export Target Stats</h5>
                            <div class="row">
                                <div class="col-md-4 my-auto">
                                    <h5>Departments</h5>
                                </div>
                                <div class="col-md my-2">
                                    <input type="text" readonly name="target-departments" placeholder="Target Departments" class="form-control" id="target-departments">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 my-auto">
                                    <h5>Courses</h5>
                                </div>
                                <div class="col-md my-2">
                                    <input type="text" readonly name="target-courses" placeholder="Target Courses" class="form-control" id="target-courses">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 my-auto">
                                    <h5>Sections</h5>
                                </div>
                                <div class="col-md my-2">
                                    <input type="text" readonly name="target-sections" placeholder="Target Sections" class="form-control" id="target-sections">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 my-2">
                            <h5 class="border-bottom my-4">Export Progress Stats</h5>
                            <div class="row">
                                <div class="col-md-4 my-auto">
                                    <h5>Departments</h5>
                                </div>
                                <div class="col-md my-2">
                                    <input type="text" readonly name="progress-departments" placeholder="Progress Departments" class="form-control" id="progress-departments">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 my-auto">
                                    <h5>Courses</h5>
                                </div>
                                <div class="col-md my-2">
                                    <input type="text" readonly name="progress-courses" placeholder="Progress Courses" class="form-control" id="progress-courses">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 my-auto">
                                    <h5>Sections</h5>
                                </div>
                                <div class="col-md my-2">
                                    <input type="text" readonly name="progress-sections" placeholder="Progress Sections" class="form-control" id="progress-sections">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/mathjs@9.3.2/lib/browser/math.min.js"></script>
    @include('course-eval.exports.scripts.init')
    @include('course-eval.exports.scripts.status')
    @include('course-eval.exports.scripts.api-caller')
    @include('course-eval.exports.scripts.formatter')
    @include('course-eval.exports.scripts.exporter')
@endsection