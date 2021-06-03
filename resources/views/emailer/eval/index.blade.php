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
                                    <input type="text" name="form_url" id="form_url" class="form-control" placeholder="Form URL" value="https://docs.google.com/forms/d/e/1FAIpQLSfr_YSNG3Bio_ahZncIaO8g4JsDYzP6HyPzG2cSUp9lH7bbFQ/viewform">
                                </div>
                                <div class="col-4 my-auto">
                                    Course Code Key:
                                </div>
                                <div class="col-8 my-2">
                                    <input type="text" name="cc_key" id="cc_key" class="form-control" placeholder="Course Code Key" value="entry.55736331">
                                </div>
                                <div class="col-4 my-auto">
                                    Theory Section Key:
                                </div>
                                <div class="col-8 my-2">
                                    <input type="text" name="ts_key" id="ts_key" class="form-control" placeholder="Theory Section Key" value="entry.2049915700">
                                </div>
                                <div class="col-4 my-auto">
                                    Lab Section Key (1):
                                </div>
                                <div class="col-8 my-2">
                                    <input type="text" name="ls1_key" id="ls1_key" class="form-control" placeholder="Lab Section Key" value="entry.495890793">
                                </div>
                                <div class="col-4 my-auto">
                                    Lab Section Key (2):
                                </div>
                                <div class="col-8 my-2">
                                    <input type="text" name="ls2_key" id="ls2_key" class="form-control" placeholder="Lab Section Key" value="entry.375660266">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 my-2">
                            <textarea name="lab_courses" id="lab_courses" class="form-control" cols="30" rows="12" placeholder="Lab Courses (comma separated)">CSE101, CSE103, CSE110, CSE111, CSE220, CSE221, , CSE250, CSE251, CSE260, CSE310, CSE321, CSE330, CSE341, CSE350, CSE360, CSE370, CSE391, CSE419, CSE420, CSE421, CSE422, CSE423, CSE430, CSE460, CSE461, CSE471, CSE474</textarea>
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