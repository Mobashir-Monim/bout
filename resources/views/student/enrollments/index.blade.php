@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="">Add Enrollments</h5>

                    <div class="row">
                        <div class="col-md-6 my-2">
                            <select name="semester" class="form-control" required id="semester">
                                <option value="">Semester</option>
                                <option value="Spring">Spring</option>
                                <option value="Summer">Summer</option>
                                <option value="Fall">Fall</option>
                            </select>
                        </div>
                        <div class="col-md-6 my-2">
                            <select name="year" class="form-control" required id="year">
                                <option value="">Year</option>
                                @for ($i = Carbon\Carbon::now()->diffInYears(Carbon\Carbon::parse('1st Jan 2022')); $i >= 0; $i--)
                                    <option value="{{ 2022 + $i }}">{{ 2022 + $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 my-2">
                            <input type="file" accept=".xlsx, .xls" name="enrollments" id="enrollments" class="form-control">
                        </div>
                        <div class="col-md-4 my-2">
                            <button type="button" class="btn btn-dark w-100" id="uploader">Add Enrollments</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-right hidden my-auto my-2" id="upload-spinner">
                            <p class="mb-0">Uploading Data, please do not close browser/tab. The page will automatically refresh after completion</p>
                            <div class="mt-2 spinner-border" role="status"><span class="sr-only">Loading...</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.8/jszip.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.8/xlsx.min.js"></script>
    @include('student.enrollments.scripts.index')

@endsection