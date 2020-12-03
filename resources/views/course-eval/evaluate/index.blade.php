@extends('layouts.app')

@section('content')
    <div class="row my-4 align-items-center">
        <div class="col-md-8">
            <h3 class="border-bottom d-none d-sm-block"><b>Course Evaluator {{ $helper->eval->id }}</b></h3>
            <h5 class="border-bottom d-block d-sm-none"><b>Course Evaluator {{ $helper->eval->id }}</b></h5>
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
        <div class="col-md-4 mb-3 text-right" id="status">
            <button class="btn btn-dark w-100 hidden" id="ranker" onclick="rankAll()">Rank All</button>
            <button class="btn btn-dark w-100 hidden" id="uploader" onclick="segregateParts()">Store Results</button>
        </div>
        <div class="col-md-2 mb-3 text-right" id="spinner"></div>
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
    @include('course-eval.evaluate.scripts.eval-matrix')
    @include('course-eval.evaluate.scripts.preprocessor')
    @include('course-eval.evaluate.scripts.course-list')
    @include('course-eval.evaluate.scripts.templates')
    @include('course-eval.evaluate.scripts.helpers')
    @include('course-eval.evaluate.scripts.analyzer')
    @include('course-eval.evaluate.scripts.aggregator')
    @include('course-eval.evaluate.scripts.eval-segregator')
    @include('course-eval.evaluate.scripts.ranker')
    @include('course-eval.evaluate.scripts.uploader')
@endsection