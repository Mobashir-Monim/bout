@extends('layouts.dashboard')

@section('content')
    <div class="row" style="height: 80vh">
        <div class="col-md-12 my-auto">
            <div class="row justify-content-center">
                <div class="col-md-10 my-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="border-bottom">Download Backup</h5>
                            <div class="row" id="download-mode">
                                <div class="col-md-12 my-2">
                                    <select name="table" class="form-control" id="download-select" onchange="updateDownloadMode()">
                                        <option value="">Please select what to download</option>
                                        <option value="all">All tables</option>
                                        @foreach ($tables as $table)
                                            <option value="{{ $table['name'] }}">{{ $table['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 my-2">
                                    <button type="button" onclick="initiateDownload()" class="btn btn-dark w-100"><span class="material-icons-outlined">download</span></button>
                                </div>
                            </div>
                            <div class="row hidden" id="download-spinner">
                                <div class="col-md-12 my-2">
                                    Downloading data... <div class="mt-2 spinner-border" role="status"><span class="sr-only">Loading...</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-10 my-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="border-bottom">Upload Backup</h5>
                            <div class="row" id="upload-mode">
                                <div class="col-md-6 my-2">
                                    <select name="table" class="form-control" id="upload-select" onchange="updateUploadMode()">
                                        <option value="">Please select what to upload</option>
                                        <option value="all">All tables</option>
                                        @foreach ($tables as $table)
                                            <option value="{{ $table['name'] }}">{{ $table['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 my-2">
                                    <input type="file" name="upload_file" class="form-control" id="upload_file">
                                </div>
                                <div class="col-md-12 my-2">
                                    <button type="button" onclick="initiateUpload()" class="btn btn-dark w-100"><span class="material-icons-outlined">publish</span></button>
                                </div>
                            </div>
                            <div class="row hidden" id="upload-spinner">
                                <div class="col-md-12 my-2">
                                    Uploading data... <div class="mt-2 spinner-border" role="status"><span class="sr-only">Loading...</span></div>
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
    @include('data-backup.scripts.index')
    @include('data-backup.scripts.download')
    @include('data-backup.scripts.upload')
@endsection