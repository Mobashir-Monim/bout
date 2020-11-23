@extends('layouts.app')

@section('content')
    <div class="row min-h">
        <div class="col-md-12 my-auto">
            <div class="card">
                <div class="card-header bg-dark text-light">
                    <h6 class="mb-0">Format saved responses</h6>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-md-6 text-center my-2">
                            <textarea name="saved_response" id="saved_response" class="form-control" style="height: 30vh; resize: none;" placeholder="Please paste the saved response here"></textarea>
                            <button class="btn btn-dark w-100 mt-2" onclick="formatJSONToText()">Format saved response</button>
                        </div>
                        <div class="col-md-6 my-2">
                            <textarea name="saved_response_output" id="saved_response_output" class="form-control" style="height: 30vh; resize: none;" placeholder="The formated response will be shown here"></textarea>
                            <button class="btn btn-dark w-100 mt-2" onclick="copyCode()">Copy formated output</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('saved-response-format.scripts')
@endsection