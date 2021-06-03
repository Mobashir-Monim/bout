@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="border-bottom">Evaluation Emailer</h5>
                    <div class="row">
                        <div class="col-md-12 my-2">
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Email Subject" value="lalaland">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-4 my-auto">
                                    Registrations:
                                </div>
                                <div class="col-8 my-2">
                                    <input type="file" name="registrations" id="registrations" class="form-control">
                                </div>
                                <div class="col-4 my-auto">
                                    Form URL:
                                </div>
                                <div class="col-8 my-2">
                                    <input type="text" name="form_url" id="form_url" class="form-control" placeholder="Form URL">
                                </div>
                                <div class="col-4 my-auto">
                                    Course Code Key:
                                </div>
                                <div class="col-8 my-2">
                                    <input type="text" name="cc_key" id="cc_key" class="form-control" placeholder="Course Code Key">
                                </div>
                                <div class="col-4 my-auto">
                                    Theory Section Key:
                                </div>
                                <div class="col-8 my-2">
                                    <input type="text" name="ts_key" id="ts_key" class="form-control" placeholder="Theory Section Key">
                                </div>
                                <div class="col-4 my-auto">
                                    Lab Section Key (1):
                                </div>
                                <div class="col-8 my-2">
                                    <input type="text" name="ls1_key" id="ls1_key" class="form-control" placeholder="Lab Section Key">
                                </div>
                                <div class="col-4 my-auto">
                                    Lab Section Key (2):
                                </div>
                                <div class="col-8 my-2">
                                    <input type="text" name="ls2_key" id="ls2_key" class="form-control" placeholder="Lab Section Key">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 my-2">
                            <textarea name="lab_courses" id="lab_courses" class="form-control" cols="30" rows="12" placeholder="Lab Courses (comma separated)"></textarea>
                        </div>
                        <div class="col-md-6 my-2" id="email-stats">

                        </div>
                        <div class="col-md-6 my-2 text-right" id="email-btn-cont">
                            <button class="btn btn-dark w-100" type="button" onclick="startEmailing()">Start Emailing</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('emailer.eval.scripts.index')
@endsection