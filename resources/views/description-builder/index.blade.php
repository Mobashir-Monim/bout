@extends('layouts.app')

@section('content')
    <style>
        .i-del i {
            color: rgb(200, 50, 50);

        }

        .i-del i:hover {
            color: rgb(255, 10, 10);
        }

        .add {
            color: rgb(50, 200, 50);
        }

        .add:hover {
            color: rgb(10, 255, 10);
        }
    </style>
    <div class="row my-4 align-items-center">
        <div class="col-8 col-sm-8">
            <h2 class="border-bottom d-none d-sm-block">buX Course Description Builder</h2>
            <h5 class="border-bottom d-block d-sm-none">buX Course Description Builder</h5>
        </div>
    </div>
    <div class="row mt-5 mb-3">
        <div class="col-md-6">
            <label class="mb-0" for="c_code">Course Code</label>
            <input type="text" name="c_code" id="c_code" class="form-control" placeholder="CSE 103">
            <span style="font-size: 70%;">Please put a space in between the alphabets and numbers</span>
        </div>
        <div class="col-md-6">
            <label class="mb-0" for="c_dept">Course Department/School</label>
            <input type="text" name="c_dept" id="c_dept" class="form-control" placeholder="CSE,Computer Science and Engineering">
            <span style="font-size: 70%;">Please put a comma in between the tags</span>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <label class="mb-0" for="c_name">Course Name</label>
            <input type="text" name="c_name" id="c_name" class="form-control" placeholder="Introduction to Computing">
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-12">
            <label class="mb-0" for="c_description">Course Description</label>
            <textarea name="c_description" id="summernote" cols="30" rows="10" placeholder="This is the course description placeholder"></textarea>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12" id="inst-cont">
            <div class="row mb-3">
                <div class="col-md">
                    <div class="row mb-3">
                        <div class="col-md">
                            <label class="mb-0" for="i_n_1">Instructor Name</label>
                            <input type="text" name="i_n_1" id="i_n_1" class="form-control" placeholder="Instructor Name">
                        </div>
                        <div class="col-md">
                            <label class="mb-0" for="i_d_1">Instructor Designation</label>
                            <input type="text" name="i_d_1" id="i_d_1" class="form-control" placeholder="Instructor Designation">
                        </div>
                        <div class="col-md">
                            <label class="mb-0" for="i_s_1">Instructor School/Department</label>
                            <input type="text" name="i_s_1" id="i_s_1" class="form-control" placeholder="Instructor Department">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <label class="mb-0" for="i_u_1">Instructor Image URL</label>
                            <input type="text" name="i_u_1" id="i_u_1" class="form-control">
                            <span style="font-size: 70%;">This is the URL that you can copy from studio after uploading the image on studio</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 d-flex align-items-end pb-1 justify-content-center i-del">
                    <!-- <i class="fa fas fa-user-minus fa-2x"></i> -->
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md"></div>
        <div class="col-md-1 d-flex align-items-end pb-1 justify-content-center">
            <i class="fa fas fa-user-plus fa-2x add" onclick="addInstructor()"></i>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <textarea name="output" cols="30" rows="2" id="output" class="form-control" placeholder="Generate Code will appear here"></textarea>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md mb-2">
            <a href="#/" class="btn btn-dark w-100" onclick="copyCode()">Copy Generated Code</a>
        </div>
        <div class="col-md">
            <a href="#/" class="btn btn-dark w-100" onclick="generateCode()">Generate buX description</a>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> --}}

    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    @include('description-builder.scripts.index')
@endsection