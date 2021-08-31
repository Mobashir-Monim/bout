@extends('layouts.dashboard')

@section('content')
    <div class="row min-h">
        <div class="col-md-12 my-auto">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-md-12">
                            <select name="map_type" onchange="changeMapDescription()" id="map_type" class="form-control border-top-0 border-right-0 border-left-0 px-0 custom-select-lg mb-3">
                                <option value="username_to_id">Map usernames to student ID</option>
                                <option value="id_to_username">Map student ID to usernames</option>
                                <option value="id_to_email">Map student ID USIS email address</option>
                                <option value="id_to_gsuite">Map student ID G-suite address</option>
                                <option value="gsuite_to_id">Map student G-suite address to ID</option>
                            </select>
                            <p id="map_description" class="bg-light p-2 border rounded border-primary text-center">
                                Convert buX usernames of students to Student ID <br>
                                <b><span class="text-danger">NOTE:</span> The file must contain a header column titled "username"</b>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 text-center my-2">
                            <input type="file" name="username_file" id="username_file" class="form-control" accept=".xlsx, .xls, .csv">
                            <button class="btn btn-dark my-2 r-25" type="button" data-toggle="tooltip" data-placement="right" title="Click me to map the selected file!" onclick="mapStudentIDs()">
                                <i class="fas fa-project-diagram"></i>
                            </button>
                            <ul class="list-group text-left">
                                <li class="list-group-item" id="username-output">No file has been mapped yet</li>
                            </ul>
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
@endsection

@section('scripts')
    @include('mapper.scripts')
@endsection