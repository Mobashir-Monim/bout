@extends('layouts.app')

@section('content')
    <div class="row min-h">
        <div class="col-md-12 my-auto">
            <div class="card">
                <div class="card-header bg-dark text-light">
                    <h6 class="mb-0">Map usernames to student ID</h6>
                </div>
                <div class="card-body p-3">
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