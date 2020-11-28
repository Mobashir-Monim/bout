@extends('layouts.app')

@section('content')
    <div class="row my-4 align-items-center">
        <div class="col-md-8">
            <h2 class="border-bottom d-none d-sm-block">Course Evaluator</h2>
            <h5 class="border-bottom d-block d-sm-none">Course Evaluator</h5>
        </div>
    </div>

    <div class="row mb-4 text-center">
        <div class="col-md-6 mb-3">
            <input type="file" name="eval-response" id="eval-response" class="form-control mb-1" accept=".xlsx, .xls">
            <label for="eval-response" class="col-form-label text-right col-12 pt-0">Eval Responses (consolidated)</label>
        </div>
        <div class="col-md-6 mb-3">
            <input type="file" name="bux-users" id="usis-registrations" class="form-control mb-1" accept=".xlsx, .xls">
            <label for="usis-registrations" class="col-form-label text-right col-12 pt-0">Registrations on USIS</label>
        </div>
        <div class="col-md-6 mb-3">
            <input type="file" name="bux-users" id="gsuite" class="form-control mb-1" accept=".xlsx, .xls">
            <label for="gsuite" class="col-form-label text-right col-12 pt-0">Gsuite List</label>
        </div>
        <div class="col-md-4 mb-3 text-right" id="status"></div>
        <div class="col-md-2 mb-3 text-right" id="spinner"></div>
    </div>

    <div class="row hidden" id="report-options">
        <div class="col-md-12">
            <h2 class="border-bottom d-none d-sm-block">Generate Eval Report</h2>
            <h5 class="border-bottom d-block d-sm-none">Generate Eval Report</h5>
            <div class="row">
                <div class="col-md-8">
                    <div class="row mb-2">
                        <div class="col-md-4 my-auto"><h5 class="my-auto">Report Type</h5></div>
                        <div class="col-md my-auto">
                            <select name="report_type" id="report_type" class="form-control" onchange="showRepFields()">
                                <option value="">Please select report type</option>
                                <option value="dept">Department Overall Report</option>
                                <option value="course">Course Overall Report</option>
                                <option value="section">Section Overall Report</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 my-auto"><h5 class="my-auto">Department</h5></div>
                        <div class="col-md my-auto">
                            <select name="department" id="department" class="form-control" onchange="showDeptCourseList()">
                                <option value="">Please select a department</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 my-auto"><h5 class="my-auto">Course</h5></div>
                        <div class="col-md my-auto">
                            <select name="course" id="course" class="form-control" onchange="showCourseSectionList()"></select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 my-auto"><h5 class="my-auto">Section</h5></div>
                        <div class="col-md my-auto">
                            <select name="section" id="section" class="form-control"></select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12" id="dup-out"></div>
    </div>

    <div class="row">
        <div class="col-md-12" id="unv-out"></div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.0/jszip.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.0/xlsx.js"></script>
    @include('course-eval.scripts.eval-matrix')
    @include('course-eval.scripts.preprocessor')
    @include('course-eval.scripts.course-list')
    @include('course-eval.scripts.templates')
    @include('course-eval.scripts.helpers')
    @include('course-eval.scripts.analyzer')
    @include('course-eval.scripts.aggregator')
    @include('course-eval.scripts.eval-segregator')
    @include('course-eval.scripts.report-generator')
@endsection