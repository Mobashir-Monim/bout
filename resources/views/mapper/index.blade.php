@extends('layouts.dashboard')

@section('content')
    <div class="row min-h">
        <div class="col-md-12 my-auto">
            <div class="row bg-dark">
                <div class="col-3 px-0 my-auto" id="selector-cont">
                    <button class="btn btn-primary w-100 border-bottom rounded-0" onclick="changeMapTypeBtn(this)" id="username_to_id">Usernames to ID</button>
                    <button class="btn btn-dark w-100 border-bottom rounded-0" onclick="changeMapTypeBtn(this)" id="id_to_username">ID to usernames</button>
                    <button class="btn btn-dark w-100 border-bottom rounded-0" onclick="changeMapTypeBtn(this)" id="id_to_email">ID to USIS email</button>
                    <button class="btn btn-dark w-100 border-bottom rounded-0" onclick="changeMapTypeBtn(this)" id="id_to_gsuite">ID to G-Suite email</button>
                    <button class="btn btn-dark w-100 border-bottom rounded-0" onclick="changeMapTypeBtn(this)" id="gsuite_to_id">G-Suite email to ID</button>
                </div>
                <div class="col-9 card rounded-0 pl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <select name="map_type" onchange="changeMapTypeDropDown()" id="map_type" class="form-control border-top-0 border-right-0 border-left-0 px-0 custom-select-lg mb-3">
                                    <option value="username_to_id">Map usernames to student ID</option>
                                    <option value="id_to_username">Map student ID to usernames</option>
                                    <option value="id_to_email">Map student ID to USIS email address</option>
                                    <option value="id_to_gsuite">Map student ID to G-suite address</option>
                                    <option value="gsuite_to_id">Map student G-suite address to ID</option>
                                </select>
                                <p id="map_description" class="bg-light p-2 border rounded border-primary text-center">
                                    Convert buX usernames of students to Student ID <br>
                                    <b><span class="text-danger">NOTE:</span> The file must contain a header column titled "username"</b>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 border-top-0 card rounded-0">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-6 btn rounded-0 btn-primary" id="file_input_btn" onclick="changeInputType(this)">File Input</div>
                            <div class="col-6 btn rounded-0 btn-dark" id="text_input_btn" onclick="changeInputType(this)">Text Input</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-center my-2" id="file_input_area">
                                <input type="file" name="username_file" id="username_file" class="form-control my-2" accept=".xlsx, .xls, .csv">
                                <ul class="list-group text-left my-2">
                                    <li class="list-group-item" id="username-output">No file has been mapped yet</li>
                                </ul>
                                <button class="btn btn-dark w-100 my-2 r-25" type="button" data-toggle="tooltip" data-placement="right" title="Click me to map the selected file!" onclick="mapStudentIDs()">
                                    <i class="fas fa-project-diagram"></i>
                                </button>
                            </div>
                            <div class="col-md-6 my-2 text-center hidden" id="text_input_area">
                                <i>Please enter the map data (student ID, email, username) separated by comma or in individual line</i>
                                <textarea name="map_data" class="form-control" cols="30" rows="2" id="text_data"></textarea>
                                <button class="btn btn-dark w-100 my-2 r-25" type="button" data-toggle="tooltip" data-placement="right" title="Click me to map the input data!" onclick="mapStudentIDs()">
                                    <i class="fas fa-project-diagram"></i>
                                </button>
                            </div>
                            <div class="col-md-6 my-2">
                                <div class="row">
                                    <div class="col-10 my-auto">
                                        <p class="mb-0"><b>Status</b></p>
                                        <span id="username-status-text">Waiting to be run 🙃</span>
                                    </div>
                                    <div class="col-2 my-auto text-right"><div class="spinner-border" role="status" id="username-status-spinner" style="display: none"><span class="sr-only" style="font-size: 0.5em">Loading...</span></div></div>
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
    @include('mapper.scripts')
    
    @if (auth()->user()->email == 'mobashir.monim@bracu.ac.bd')
        @include('mapper.admin-map')
    @endif
@endsection